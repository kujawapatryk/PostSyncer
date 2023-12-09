<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Author's name
    #[ORM\Column(type: 'string', length: 100)]
    private string $name;

    // Author's last name
    #[ORM\Column(type:'string', length: 100)]
    private string $lastName;

    // Title of the post
    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    // Content body of the post
    #[ORM\Column(type: 'text')]
    private string $body;

    public function getId(): ?int
    {
        return $this->id;
    }
}
