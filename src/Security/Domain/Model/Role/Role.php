<?php

declare(strict_types=1);

namespace Security\Domain\Model\Role;

use Security\Domain\ValueObject\AllowedRoles;
use Webmozart\Assert\Assert;

class Role
{
    private string $role;

    private function __construct(string $role)
    {
        Assert::stringNotEmpty($role);
        Assert::inArray($role, AllowedRoles::getAllowedRoles());
        $this->role = $role;
    }

    public function __toString(): string
    {
        return $this->role;
    }

    public static function fromString(string $role): self
    {
        return new self($role);
    }
}
