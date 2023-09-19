<?php

declare(strict_types=1);

namespace Security\Domain\Model;

use Webmozart\Assert\Assert;

class Name
{
    private string $name;

    private function __construct(string $name)
    {
        Assert::stringNotEmpty($name);
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }
}
