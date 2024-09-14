<?php

namespace Security\Domain\Dto;

use Security\Domain\ValueObject\Email;
use Security\Domain\ValueObject\Name;
use Security\Domain\ValueObject\Password;
use Security\Domain\ValueObject\Role\Roles;
use Security\Domain\ValueObject\Uuid;

readonly class UserToCreate
{
    public function __construct(
        private Uuid $uuid,
        private Name $username,
        private Email $email,
        private Roles $roles,
        private Password $password
    ) {
    }

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

    public function getRoles(): Roles
    {
        return $this->roles;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }
}
