<?php

declare(strict_types=1);

namespace Security\Infrastructure\Repository;

use Security\Domain\Model\User\User;
use Security\Domain\Model\User\UserInterface;
use Security\Domain\Repository\UserRepositoryInterface;
use Security\Infrastructure\Repository\DBAL\DBALRepositoryFactory;
use Broadway\ReadModel\Repository;
use Webmozart\Assert\Assert;

class UserRepository implements UserRepositoryInterface
{
    private Repository $repository;

    public function __construct(DBALRepositoryFactory $DBALRepositoryFactory)
    {
        $this->repository = $DBALRepositoryFactory->create('user', User::class);
    }

    public function save(UserInterface $user): void
    {
        Assert::isInstanceOf($user, User::class);

        /** @var User $user */
        $this->repository->save($user);
    }
}
