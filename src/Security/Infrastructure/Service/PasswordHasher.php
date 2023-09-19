<?php

declare(strict_types=1);

namespace Security\Infrastructure\Service;

use DomainException;
use Security\Domain\Model\User\UserInterface;
use Security\Domain\Service\PasswordHasher as DomainPasswordHasher;
use Security\Infrastructure\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class PasswordHasher implements DomainPasswordHasher
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function hashPassword(UserInterface $user, string $plainPassword): string
    {
        if ($user instanceof User) {
            return $this->passwordHasher->hashPassword($user, $plainPassword);
        }

        throw new DomainException('getPassword() method is missing from the current UserInterface');
    }
}
