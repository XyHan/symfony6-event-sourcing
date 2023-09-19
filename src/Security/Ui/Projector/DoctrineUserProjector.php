<?php

declare(strict_types=1);

namespace Security\Ui\Projector;

use Broadway\ReadModel\Projector;
use Security\Domain\Event\UserHasBeenCreated;
use Security\Domain\Service\PasswordHasher;
use Security\Domain\Service\Validator;
use Security\Infrastructure\Entity\User;
use Security\Infrastructure\Repository\DoctrineUserRepository;

class DoctrineUserProjector extends Projector
{
    public function __construct(
        private readonly DoctrineUserRepository $repository,
        private readonly PasswordHasher $passwordHasher,
        private readonly Validator $userValidator,
    ) {}

    protected function applyUserHasBeenCreated(UserHasBeenCreated $event): void
    {
        $user = new User(
            (string) $event->getUserId(),
            (string) $event->getUsername(),
            (string) $event->getEmail(),
            null,
            $event->getRoles()->toArray()
        );

        $user->setPassword(
            $this->passwordHasher->hashPassword($user, (string) $event->getPassword())
        );

        $this->userValidator->validate($user);

        $this->repository->create($user);
    }
}
