<?php

namespace Security\Domain\Dto;

use Security\Application\Command\CreateAUser\CreateAUserCommand;
use Security\Domain\Model\Email;
use Security\Domain\Model\Name;
use Security\Domain\Model\Password;
use Security\Domain\Model\Role\Roles;
use Security\Domain\Model\Uuid;

class UserToCreate
{
    private function __construct(
        protected Uuid $uuid,
        protected Name $username,
        protected Email $email,
        protected Roles $roles,
        protected Password $password
    ) {
    }

    public static function fromCommand(CreateAUserCommand $command): self
    {
        return new self(
            $command->getUuid(),
            $command->getUsername(),
            $command->getEmail(),
            $command->getRoles(),
            $command->getPassword()
        );
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
