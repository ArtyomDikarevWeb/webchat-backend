<?php
declare(strict_types=1);

namespace App\Entity;

use App\Enum\UserRole;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: '`users`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'bigint')]
    public ?int $id;

    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'uuid', unique: true, insertable: false)]
    public ?string $uuid = null;

    #[ORM\Column(type: 'string', length: 255)]
    public string $username;

    #[ORM\Column(type: 'string', length: 255)]
    public string $email;

    #[ORM\Column(type: 'string', length: 255)]
    public string $password;

    #[Orm\Column(enumType: UserRole::class, insertable: false)]
    public UserRole $role;

    #[Orm\Column(type: 'datetime_immutable', insertable: false)]
    public ?DateTimeImmutable $createdAt = null;

    #[Orm\Column(type: 'datetime_immutable', insertable: false)]
    public ?DateTimeImmutable $updatedAt = null;

    #[Orm\Column(type: 'datetime_immutable')]
    public ?DateTimeImmutable $deletedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }

    public function getRoles(): array
    {
        return [UserRole::User];
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function setRole(UserRole $role): void
    {
        $this->role = $role;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
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

    #[ORM\PrePersist]
    public function setDefaultRole(): void
    {
        if (!isset($this->role)) {
            $this->role = UserRole::User;
        }
    }
}
