<?php

declare(strict_types=1);

namespace Security\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;
use Security\Domain\Model\User\UserInterface as DomainUserInterface;
use Security\Domain\ValueObject\AllowedRoles;
use Security\Infrastructure\Repository\DoctrineUserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DoctrineUserRepository::class)]
#[ORM\Table(name: 'user')]
#[ORM\Index(columns: ['uuid'], name: 'uuid_search_idx', flags: ['fulltext'])]
#[ORM\Index(columns: ['username'], name: 'username_search_idx', flags: ['fulltext'])]
#[ORM\Index(columns: ['email'], name: 'email_search_idx', flags: ['fulltext'])]
#[ORM\UniqueConstraint(name: 'uniqueness_idx', columns: ['uuid', 'username', 'email'])]
#[UniqueEntity(fields: ['uuid'], message: 'This uuid already exists', errorPath: 'uuid')]
#[UniqueEntity(fields: ['username'], message: 'This username already exists', errorPath: 'username')]
#[UniqueEntity(fields: ['email'], message: 'This email already exists', errorPath: 'email')]
final class User implements UserInterface, PasswordAuthenticatedUserInterface, DomainUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Ignore]
    private ?int $id;

    #[Assert\Uuid]
    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private string $uuid;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private string $username;

    #[Assert\Email]
    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [AllowedRoles::class, 'getAllowedRoles'], multiple: true)]
    #[ORM\Column(type: 'json')]
    private array $roles;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string')]
    #[Ignore]
    private ?string $password;

    public function __construct(string $uuid, string $username, string $email, ?string $password, array $roles = [])
    {
        $this->id = null;
        $this->uuid = $uuid;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getUserIdentifier(): string
    {
        return $this->uuid;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void {}
}
