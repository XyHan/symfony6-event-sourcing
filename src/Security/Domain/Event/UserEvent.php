<?php

namespace Security\Domain\Event;

use Broadway\Serializer\Serializable;
use Security\Domain\Identifier\UserIdentifier;

abstract readonly class UserEvent implements Serializable
{
    public function __construct(private UserIdentifier $userId) {}

    public function serialize(): array
    {
        return ['userId' => (string) $this->userId];
    }

    public function getUserId(): UserIdentifier
    {
        return $this->userId;
    }
}
