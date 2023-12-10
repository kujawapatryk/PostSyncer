<?php

namespace App\Service;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createPost(array $data): Post
    {
        $post = new Post();
        $post->setName($data['name'] ?? null);
        $post->setTitle($data['title'] ?? null);
        $post->setBody($data['body'] ?? null);
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post;
    }
}