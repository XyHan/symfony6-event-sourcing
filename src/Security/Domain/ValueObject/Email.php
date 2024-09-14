<?php

declare(strict_types=1);

namespace Security\Domain\ValueObject;

use Webmozart\Assert\Assert;

class Email
{
    private string $email;

    private function __construct(string $email)
    {
        Assert::stringNotEmpty($email);
        Assert::email($email);
        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }
}
