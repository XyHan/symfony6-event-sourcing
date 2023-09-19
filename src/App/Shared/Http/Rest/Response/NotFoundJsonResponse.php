<?php

declare(strict_types=1);

namespace App\Shared\Http\Rest\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class NotFoundJsonResponse extends JsonResponse
{
    public static function fromException(Throwable $exception): self
    {
        $data = [
            'code' => Response::HTTP_NOT_FOUND,
            'message' => $exception->getMessage(),
        ];

        return new self($data, Response::HTTP_NOT_FOUND);
    }
}
