<?php

declare(strict_types=1);

namespace App\Shared\Http\Rest\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationsJsonResponse extends JsonResponse
{
    public static function fromList(ConstraintViolationListInterface $violationList): self
    {
        $data = [
            'code' => Response::HTTP_BAD_REQUEST,
            'violations' => array_map(static fn (ConstraintViolationInterface $violation) => [
                'message' => $violation->getMessage(),
                'property' => $violation->getPropertyPath(),
                'invalidValue' => $violation->getInvalidValue() ?? null,
            ], $violationList->getIterator()->getArrayCopy()),
        ];

        return new self($data, Response::HTTP_BAD_REQUEST);
    }
}
