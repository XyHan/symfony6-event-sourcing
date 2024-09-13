<?php

namespace Security\Domain\Dto;

use Security\Domain\Model\Email;
use Security\Domain\Model\Name;
use Security\Domain\Model\Password;
use Security\Domain\Model\Role\Roles;
use Security\Domain\Model\Uuid;

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
