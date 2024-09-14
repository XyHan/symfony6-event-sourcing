<?php

declare(strict_types=1);

namespace App\Security\ReadModel;

use Broadway\ReadModel\SerializableReadModel;
use Security\Domain\Identifier\UserIdentifier;
use Security\Domain\ValueObject\Email;
use Security\Domain\ValueObject\Name;
use Security\Domain\ValueObject\Role\Roles;
use Security\Domain\Model\User\User as DomainUser;

readonly class User extends DomainUser implements SerializableReadModel
{
    private function __construct(
        UserIdentifier $userIdentifier,
        Name $username,
        Email $email,
        Roles $roles
    ) {
        parent::__construct($userIdentifier, $username, $email, $roles);
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
