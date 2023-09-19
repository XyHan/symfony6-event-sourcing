<?php

namespace Security\Domain\Service;

interface Validator
{
    public function validate(mixed $value): void;
}
