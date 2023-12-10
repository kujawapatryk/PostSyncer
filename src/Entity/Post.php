<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'conference:item']),
        new GetCollection(normalizationContext: ['groups' => 'conference:list'])
    ],
    paginationEnabled: false,
)]

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Author's name
    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

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

    public function getBody(): string
    {
        return $this->body;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


}
