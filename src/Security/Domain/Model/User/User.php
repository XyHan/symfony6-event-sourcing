<?php

declare(strict_types=1);

namespace Security\Domain\Model\User;

use Security\Domain\Identifier\UserIdentifier;
use Security\Domain\ValueObject\Email;
use Security\Domain\ValueObject\Name;
use Security\Domain\ValueObject\Role\Roles;

readonly class User implements UserInterface
{
    public function __construct(
        protected UserIdentifier $userIdentifier,
        protected Name $username,
        protected Email $email,
        protected Roles $roles
    ) {
    }

    public function getId(): string
    {
        return (string) $this->userIdentifier;
    }
}
