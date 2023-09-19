<?php

namespace Security\Domain\Service;

use Security\Domain\Model\User\UserInterface;

interface PasswordHasher
{
    public function hashPassword(UserInterface $user, string $plainPassword): string;
}
