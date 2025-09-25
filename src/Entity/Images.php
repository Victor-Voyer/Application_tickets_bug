<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Tickets $ticket_id = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Comments $comment_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getTicketId(): ?Tickets
    {
        return $this->ticket_id;
    }

    public function setTicketId(?Tickets $ticket_id): static
    {
        $this->ticket_id = $ticket_id;

        return $this;
    }

    public function getCommentId(): ?Comments
    {
        return $this->comment_id;
    }

    public function setCommentId(?Comments $comment_id): static
    {
        $this->comment_id = $comment_id;

        return $this;
    }
}
