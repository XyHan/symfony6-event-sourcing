<?php

declare(strict_types=1);

namespace Security\Domain\Model;

use Webmozart\Assert\Assert;

class Password
{
    private string $password;

    private function __construct(string $password)
    {
        Assert::stringNotEmpty($password);
        $this->password = $password;
    }

    public function __toString(): string
    {
        return $this->password;
    }

    public static function fromString(string $password): self
    {
        return new self($password);
    }
}
