<?php

declare(strict_types=1);

namespace Security\Application\Command\CreateAUser;

use Security\Domain\Model\Email;
use Security\Domain\Model\Name;
use Security\Domain\Model\Password;
use Security\Domain\Model\Role\Roles;
use Security\Domain\Model\Uuid;

readonly class CreateAUserCommand
{
    public function __construct(
        private string $uuid,
        private string $username,
        private string $email,
        private string $password,
        private array $roles
    ) {}

    public function getUuid(): Uuid
    {
        return Uuid::fromString($this->uuid);
    }

    public function getUsername(): Name
    {
        return Name::fromString($this->username);
    }

    public function getEmail(): Email
    {
        return Email::fromString($this->email);
    }

    public function getPassword(): Password
    {
        return Password::fromString($this->password);
    }

    public function getRoles(): Roles
    {
        return Roles::fromArray($this->roles);
    }
}
