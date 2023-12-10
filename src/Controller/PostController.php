<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{

    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    #[Route('/lista', name: 'post_list')]
    public function index(): Response
    {
        $posts = $this->postRepository->findAll();

        return $this->render('post/list.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/post/delete/{id}', name: 'post_delete')]
    public function delete(int $id, PostService $postService): Response
    {
        $post = $this->postRepository->find($id);
        if ($post) {
            $postService->deletePost($post);
            $this->addFlash('success', 'Post został pomyślnie usunięty.');
        } else {
            $this->addFlash('error', 'Post nie został znaleziony.');
        }

        return $this->redirectToRoute('post_list');
    }
}
