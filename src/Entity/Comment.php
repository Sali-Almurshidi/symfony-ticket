<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $commentStatus;
    // 0 public 1 private

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ticket", inversedBy="commentId")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ticketId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commentsId")
     */
    private $userId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getCommentStatus(): ?int
    {
        return $this->commentStatus;
    }

    public function setCommentStatus(int $commentStatus): self
    {
        $this->commentStatus = $commentStatus;

        return $this;
    }

    public function getTicketId(): ?Ticket
    {
        return $this->ticketId;
    }

    public function setTicketId(?Ticket $ticketId): self
    {
        $this->ticketId = $ticketId;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
