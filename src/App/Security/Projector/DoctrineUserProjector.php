<?php

declare(strict_types=1);

namespace App\Security\Projector;

use Broadway\ReadModel\Projector;
use Security\Domain\Event\UserHasBeenCreated;
use Security\Domain\Model\User\User as ReadModel;
use Security\Domain\Model\User\UserInterface;
use Security\Domain\Service\PasswordHasher;
use Security\Domain\Service\Validator;
use Security\Infrastructure\Entity\User;
use Security\Infrastructure\Repository\DoctrineUserRepository;
use Security\Infrastructure\Repository\UserRepository;

class DoctrineUserProjector extends Projector
{
    public function __construct(
        private readonly DoctrineUserRepository $doctrineUserRepository,
        private readonly UserRepository $readModelRepository,
        private readonly PasswordHasher $passwordHasher,
        private readonly Validator $userValidator,
    ) {}

    protected function applyUserHasBeenCreated(UserHasBeenCreated $event): void
    {
        $this->readModelRepository->save($this->getUserReadModelFromEvent($event));
        $this->doctrineUserRepository->create($this->getDoctrineUserFromEvent($event));
    }

    private function getDoctrineUserFromEvent(UserHasBeenCreated $event): UserInterface
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

        return $user;
    }

    private function getUserReadModelFromEvent(UserHasBeenCreated $event): UserInterface
    {
        return ReadModel::fromArray([
            'id' => (string) $event->getUserId(),
            'username' => (string) $event->getUsername(),
            'email' => (string) $event->getEmail(),
            'roles' => $event->getRoles()->toArray()
        ]);
    }
}
