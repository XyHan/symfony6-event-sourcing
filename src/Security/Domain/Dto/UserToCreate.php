<?php

namespace Security\Domain\Dto;

use Security\Domain\ValueObject\Email;
use Security\Domain\ValueObject\Name;
use Security\Domain\ValueObject\Password;
use Security\Domain\ValueObject\Role\Roles;
use Security\Domain\ValueObject\Uuid;

class UserToCreate
{
    public function __construct(
        protected Uuid $uuid,
        protected Name $username,
        protected Email $email,
        protected Roles $roles,
        protected Password $password
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
