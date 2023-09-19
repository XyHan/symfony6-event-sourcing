<?php

declare(strict_types=1);

namespace Security\Domain\ValueObject;

use Security\Domain\Model\Role\Role;

class AllowedRoles
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    public static function getAllowedRoles(): array
    {
        return [self::ROLE_USER, self::ROLE_ADMIN, self::ROLE_SUPER_ADMIN];
    }

    public static function user(): Role
    {
        return Role::fromString(self::ROLE_USER);
    }

    public static function admin(): Role
    {
        return Role::fromString(self::ROLE_ADMIN);
    }

    public static function superAdmin(): Role
    {
        return Role::fromString(self::ROLE_SUPER_ADMIN);
    }
}
