<?php

declare(strict_types=1);

namespace Security\Domain\AggregateRoot;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Security\Domain\Dto\UserToCreate;
use Security\Domain\Event\UserHasBeenCreated;
use Security\Domain\Identifier\UserIdentifier;
use Security\Domain\ValueObject\Email;
use Security\Domain\ValueObject\Name;
use Security\Domain\ValueObject\Password;
use Security\Domain\ValueObject\Role\Roles;

class User extends EventSourcedAggregateRoot
{
    private ?UserIdentifier $userId;
    private ?Password $password;
    private ?Email $email;
    private ?Name $username;
    private Roles $roles;

    public function __construct()
    {
        $this->userId = null;
        $this->password = null;
        $this->email = null;
        $this->username = null;
        $this->roles = Roles::fromArray([]);
    }

    public function getAggregateRootId(): string
    {
        return (string) $this->userId;
    }

    public static function create(UserToCreate $userToInit): User
    {
        $user = new self();
        $user->apply(
            new UserHasBeenCreated(
                UserIdentifier::fromString((string) $userToInit->getUuid()),
                $userToInit->getEmail(),
                $userToInit->getUsername(),
                $userToInit->getPassword(),
                $userToInit->getRoles()
            )
        );

        return $user;
    }

    protected function applyUserHasBeenCreated(UserHasBeenCreated $event): void
    {
        $this->userId = $event->getUserId();
        $this->password = $event->getPassword();
        $this->username = $event->getUsername();
        $this->email = $event->getEmail();
        $this->roles = $event->getRoles();
    }
}
