<?php

declare(strict_types=1);

namespace Security\Infrastructure\Repository;

use App\Security\ReadModel\User;
use Broadway\ReadModel\Repository;
use Security\Domain\Model\User\UserInterface;
use Security\Domain\Repository\UserRepositoryInterface;
use Core\Repository\ReadModelRepository\DBALReadModelRepositoryFactory;
use Webmozart\Assert\Assert;

class UserRepository implements UserRepositoryInterface
{
    private Repository $repository;

    public function __construct(DBALReadModelRepositoryFactory $DBALRepositoryFactory)
    {
        $this->repository = $DBALRepositoryFactory->create('rm_user', User::class);
    }

    public function save(UserInterface $user): void
    {
        Assert::isInstanceOf($user, User::class);

        /** @var User $user */
        $this->repository->save($user);
    }

    public function getInstance(): Repository
    {
        return $this->repository;
    }
}
