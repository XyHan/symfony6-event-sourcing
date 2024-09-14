<?php

declare(strict_types=1);

namespace Security\Domain\Model\User;

use Security\Domain\Identifier\UserIdentifier;
use Security\Domain\Model\Email;
use Security\Domain\Model\Name;
use Security\Domain\Model\Role\Roles;

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
