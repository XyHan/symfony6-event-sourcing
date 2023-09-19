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
        private Uuid $uuid,
        private Name $username,
        private Email $email,
        private Password $password,
        private Roles $roles
    ) {}

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getUsername(): Name
    {
        return $this->username;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getRoles(): Roles
    {
        return $this->roles;
    }
}
