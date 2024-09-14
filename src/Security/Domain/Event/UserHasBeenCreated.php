<?php

declare(strict_types=1);

namespace Security\Domain\Event;

use Security\Domain\Identifier\UserIdentifier;
use Security\Domain\ValueObject\Email;
use Security\Domain\ValueObject\Name;
use Security\Domain\ValueObject\Password;
use Security\Domain\ValueObject\Role\Roles;

readonly class UserHasBeenCreated extends UserEvent
{
    public function __construct(
        UserIdentifier $userId,
        private Email $email,
        private Name $username,
        private Password $password,
        private Roles $roles
    ) {
        parent::__construct($userId);
    }

    public function serialize(): array
    {
        return array_merge(parent::serialize(), [
            'email' => (string) $this->email,
            'username' => (string) $this->username,
            'password' => (string) $this->password,
            'roles' => $this->roles->toArray(),
        ]);
    }

    public static function deserialize(array $data)
    {
        return new self(
            UserIdentifier::fromString($data['userId']),
            Email::fromString($data['email']),
            Name::fromString($data['username']),
            Password::fromString($data['password']),
            Roles::fromArray($data['roles'])
        );
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getUsername(): Name
    {
        return $this->username;
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
