<?php

namespace Security\Domain\Repository;

use Security\Domain\Model\User\UserInterface;

interface UserRepositoryInterface
{
    public function save(UserInterface $user): void;
}
