<?php

declare(strict_types=1);

namespace Security\Infrastructure\Service;

use Security\Domain\Service\Validator as DomainValidator;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class Validator implements DomainValidator
{
    public function __construct(private ValidatorInterface $validator) {}

    public function validate(mixed $value): void
    {
        $violations = $this->validator->validate($value);
        if ($violations->count() > 0) {
            throw new ValidationFailedException($value, $violations);
        }
    }
}
