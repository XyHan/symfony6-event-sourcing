<?php

declare(strict_types=1);

namespace Security\Domain\ValueObject\Role;

use Webmozart\Assert\Assert;

class Roles
{
    /**
     * @var array<string>
     */
    private array $roles;

    private function __construct(array $roles)
    {
        Assert::allIsInstanceOf($roles, Role::class);
        $this->roles = $roles;
    }

    public static function fromArray(array $roles): self
    {
        return new self(
            array_map(
                static fn (Role|string $role) => $role instanceof Role ? $role : Role::fromString($role),
                $roles
            )
        );
    }

    public function toArray(): array
    {
        return array_map(
            static fn (string|Role $role) => (string) $role,
            $this->roles
        );
    }
}
