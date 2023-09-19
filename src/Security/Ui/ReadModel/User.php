<?php

declare(strict_types=1);

namespace Security\Ui\ReadModel;

use Broadway\ReadModel\SerializableReadModel;
use Security\Domain\Identifier\UserIdentifier;
use Security\Domain\Model\Email;
use Security\Domain\Model\Name;
use Security\Domain\Model\Role\Roles;

readonly class User implements SerializableReadModel
{
    private function __construct(
        private UserIdentifier $userIdentifier,
        private Name $username,
        private Email $email,
        private Roles $roles
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            UserIdentifier::fromString($data['id']),
            Name::fromString($data['username']),
            Email::fromString($data['email']),
            Roles::fromArray($data['roles'])
        );
    }

    public function getId(): string
    {
        return (string) $this->userIdentifier;
    }

    public function serialize(): array
    {
        return [
            'id' => (string) $this->userIdentifier,
            'username' => (string) $this->username,
            'email' => (string) $this->email,
            'roles' => $this->roles->toArray(),
        ];
    }

    public static function deserialize(array $data)
    {
        return User::fromArray($data);
    }
}
