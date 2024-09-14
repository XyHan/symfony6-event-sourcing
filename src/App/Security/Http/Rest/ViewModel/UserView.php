<?php

declare(strict_types=1);

namespace App\Security\Http\Rest\ViewModel;

use Security\Application\Command\CreateAUser\CreateAUserCommand;
use Security\Domain\ValueObject\Name;
use Security\Domain\ValueObject\Uuid;

readonly class UserView
{
    private function __construct(private Uuid $uuid, private Name $username) {}

    public static function fromCreateUserCommand(CreateAUserCommand $command): self
    {
        return new self($command->getUuid(), $command->getUsername());
    }

    public function toArray(): array
    {
        return ['uuid' => (string) $this->uuid, 'username' => (string) $this->username];
    }
}
