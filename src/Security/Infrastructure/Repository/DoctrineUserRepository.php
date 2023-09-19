<?php

declare(strict_types=1);

namespace Security\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Security\Domain\Model\User\UserInterface;
use Security\Infrastructure\Entity\User;

class DoctrineUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function create(UserInterface $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
