<?php

declare(strict_types=1);

namespace Security\Domain\Model\Role;

class Roles
{
    /**
     * @var array<string>
     */
    private array $roles;

    private function __construct(array $roles)
    {
        $this->roles = $roles;
    }

    public static function fromArray(array $roles): self
    {
        return new self($roles);
    }

    public function toArray(): array
    {
        return array_map(
            static fn (string|Role $role) => (string) $role,
            $this->roles
        );
    }
}
