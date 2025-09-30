<?php

namespace App\Entity;

use App\Enum\Stacks;
use App\Repository\TicketsRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketsRepository::class)]
class Tickets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\PrePersist]
    public function setCreatedAtValue()
    {
        if($this->created_at === null){
            $this->created_at = new DateTimeImmutable();
        }
    }

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(name: 'user_id', nullable: false)]
    private ?Users $user_id = null;

    #[ORM\Column(enumType: Stacks::class)]
    private ?Stacks $stack = null;

    #[ORM\Column(enumType: Types::class)]
    private ?\App\Enum\Types $type = null;

    // #[ORM\ManyToOne(inversedBy: 'ticket')]
    // private ?Comments $comments = null;

    /**
     * @var Collection<int, Comments>
     */

    #[ORM\OneToMany(targetEntity: Comments::class, mappedBy: 'ticket', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $comments;

    /**
     * @var Collection<int, Images>
     */
    #[ORM\OneToMany(targetEntity: Images::class, mappedBy: 'ticket_id')]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUserId(): ?Users
    {
        return $this->user_id;
    }

    public function setUserId(?Users $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getStack(): ?Stacks
    {
        return $this->stack;
    }

    public function setStack(Stacks $stack): static
    {
        $this->stack = $stack;

        return $this;
    }

    public function getType(): ?\App\Enum\Types
    {
        return $this->type;
    }

    public function setType(\App\Enum\Types $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */

    public function getComments(): ?Collection
    {
        return $this->comments;
    }

    public function addComment(?Comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->contains($comment);
            $comment->setTicket(($this));
        }
        return $this;
    }
    public function removeComment(Comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            if ($comment->getTicket() === $this) {
                $comment->setTicket(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setTicketId($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getTicketId() === $this) {
                $image->setTicketId(null);
            }
        }

        return $this;
    }
}
