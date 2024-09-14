<?php

declare(strict_types=1);

namespace Security\Application\Command\CreateAUser;

use Broadway\CommandHandling\SimpleCommandHandler;
use Security\Domain\Repository\EventStoreRepositoryInterface;
use Security\Domain\AggregateRoot\User;
use Security\Domain\Dto\UserToCreate;

class CreateAUserCommandHandler extends SimpleCommandHandler
{
    public function __construct(private readonly EventStoreRepositoryInterface $repository) {}

    public function handleCreateAUserCommand(CreateAUserCommand $command): void
    {
        $user = User::create(new UserToCreate(
            $command->getUuid(),
            $command->getUsername(),
            $command->getEmail(),
            $command->getRoles(),
            $command->getPassword()
        ));
        $this->repository->save($user);
    }
}
