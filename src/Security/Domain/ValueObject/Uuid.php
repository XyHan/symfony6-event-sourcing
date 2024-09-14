<?php

declare(strict_types=1);

namespace Security\Domain\ValueObject;

use Webmozart\Assert\Assert;

class Uuid
{
    private string $uuid;

    private function __construct(string $uuid)
    {
        Assert::uuid($uuid);
        $this->uuid = $uuid;
    }

    public function __toString(): string
    {
        return $this->uuid;
    }

    public static function fromString(string $uuid): self
    {
        return new self($uuid);
    }
}
