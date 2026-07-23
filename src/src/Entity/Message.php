<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private int $userId;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private int $chatId;

    #[ORM\Column(type: 'text')]
    private string $text;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $deletedAt = null;

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getChatId(): int
    {
        return $this->chatId;
    }

    public function setChatId(int $chatId): void
    {
        $this->chatId = $chatId;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(DateTimeImmutable $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}
