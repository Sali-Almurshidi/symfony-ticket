<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ticketTitle;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $openTime;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $closeTime;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reopen;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ticketStatus;

    /**
     * @ORM\Column(type="integer")
     */
    private $priority;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tickets")
     */
    private $customerId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="ticketId", orphanRemoval=true)
     */
    private $commentId;

    public function __construct()
    {
        $this->commentId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicketTitle(): ?string
    {
        return $this->ticketTitle;
    }

    public function setTicketTitle(string $ticketTitle): self
    {
        $this->ticketTitle = $ticketTitle;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getOpenTime(): ?\DateTimeInterface
    {
        return $this->openTime;
    }

    public function setOpenTime(?\DateTimeInterface $openTime): self
    {
        $this->openTime = $openTime;

        return $this;
    }

    public function getCloseTime(): ?\DateTimeInterface
    {
        return $this->closeTime;
    }

    public function setCloseTime(?\DateTimeInterface $closeTime): self
    {
        $this->closeTime = $closeTime;

        return $this;
    }

    public function getReopen(): ?int
    {
        return $this->reopen;
    }

    public function setReopen(?int $reopen): self
    {
        $this->reopen = $reopen;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTicketStatus(): ?string
    {
        return $this->ticketStatus;
    }

    public function setTicketStatus(string $ticketStatus): self
    {
        $this->ticketStatus = $ticketStatus;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getCustomerId(): ?User
    {
        return $this->customerId;
    }

    public function setCustomerId(?User $customerId): self
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getCommentId(): Collection
    {
        return $this->commentId;
    }

    public function addCommentId(Comment $commentId): self
    {
        if (!$this->commentId->contains($commentId)) {
            $this->commentId[] = $commentId;
            $commentId->setTicketId($this);
        }

        return $this;
    }

    public function removeCommentId(Comment $commentId): self
    {
        if ($this->commentId->contains($commentId)) {
            $this->commentId->removeElement($commentId);
            // set the owning side to null (unless already changed)
            if ($commentId->getTicketId() === $this) {
                $commentId->setTicketId(null);
            }
        }

        return $this;
    }
}
