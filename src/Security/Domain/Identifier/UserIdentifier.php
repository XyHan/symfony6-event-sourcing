<?php

declare(strict_types=1);

namespace Security\Domain\Identifier;

final class UserIdentifier
{
    private string $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }
}
