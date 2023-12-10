<?php

namespace App\Command;

use App\Service\PostService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

use Throwable;

#[AsCommand(
    name: 'FetchPostsCommand',
    description: 'FetchPostsCommand responsible for fetching post data from the API',
)]
class FetchPostsCommand extends Command
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        parent::__construct();
        $this->postService = $postService;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = HttpClient::create();

        try {
            $postsResponse = $client->request('GET', 'https://jsonplaceholder.typicode.com/posts');
            if ($postsResponse->getStatusCode() !== 200) {
                $output->writeln("Error fetching posts: HTTP Status " . $postsResponse->getStatusCode());
                return Command::FAILURE;
            }
            $posts = $postsResponse->toArray();

            $usersResponse = $client->request('GET', 'https://jsonplaceholder.typicode.com/users');
            if ($usersResponse->getStatusCode() !== 200) {
                $output->writeln("Error fetching users: : HTTP Status " . $usersResponse->getStatusCode());
                return Command::FAILURE;
            }
            $users = $usersResponse->toArray();
        } catch (Throwable $e) {
            $output->writeln("Error during fetching data: " . $e->getMessage());
            return Command::FAILURE;
        }

        $userMap = array_column($users, 'name', 'id');
        $output->writeln("\nFetched Users:");
        foreach ($posts as $post) {
            $post['name'] = $userMap[$post['userId']] ?? null;
            if ($post['name'] === null) {
                $output->writeln("No user found for post {$post['id']}");
            }
            $this->postService->createPost($post);
            $output->writeln('User ID: ' . $post['id'] . ' - Name: ' . $post['name'] . ' - Title: ' . $post['title']);
        }
        $output->writeln("Data fetching completed.");
        return Command::SUCCESS;
    }
}
