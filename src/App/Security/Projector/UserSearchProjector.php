<?php

declare(strict_types=1);

namespace App\App\Security\Projector;

use App\App\Security\ReadModel\User as ReadModel;
use Broadway\ReadModel\Projector;
use Security\Domain\Event\UserHasBeenCreated;
use Security\Infrastructure\Repository\UserRepository;

class UserSearchProjector extends Projector
{
    public function __construct(private readonly UserRepository $readModelRepository) {}

    protected function applyUserHasBeenCreated(UserHasBeenCreated $event): void
    {
        $this->readModelRepository->save(ReadModel::fromArray([
            'id' => (string) $event->getUserId(),
            'username' => (string) $event->getUsername(),
            'email' => (string) $event->getEmail(),
            'roles' => $event->getRoles()->toArray()
        ]));
    }
}
