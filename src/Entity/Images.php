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
    #[ORM\JoinColumn(name: 'ticket_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Tickets $ticket = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(name: 'comment_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Comments $comment = null;

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

    public function getTicket(): ?Tickets
    {
        return $this->ticket;
    }

    public function setTicket(?Tickets $ticket): static
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getComment(): ?Comments
    {
        return $this->comment;
    }

    public function setComment(?Comments $comment): static
    {
        $this->comment = $comment;

        return $this;
    }
}
