<?php

declare(strict_types=1);

namespace App\Shared\Http\Rest\Listener;

use App\Shared\Http\Rest\Response\BadRequestJsonResponse;
use App\Shared\Http\Rest\Response\ExceptionJsonResponse;
use App\Shared\Http\Rest\Response\NotAllowedJsonResponse;
use App\Shared\Http\Rest\Response\NotFoundJsonResponse;
use App\Shared\Http\Rest\Response\ViolationsJsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use TypeError;

class OnErrorListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        switch ($exception) {
            case $exception instanceof ValidationFailedException:
                $event->setResponse(ViolationsJsonResponse::fromList($exception->getViolations()));

                break;

            case $exception instanceof NotFoundHttpException:
                $event->setResponse(NotFoundJsonResponse::fromException($exception));

                break;

            case $exception instanceof MethodNotAllowedHttpException:
                $event->setResponse(NotAllowedJsonResponse::fromException($exception));

                break;

            case $exception instanceof NotNormalizableValueException:
                $event->setResponse($this->violationResponseFromUnexpectedValue($exception));

                break;

            case $exception instanceof TypeError:
                $event->setResponse(BadRequestJsonResponse::fromException($exception));

                break;

            default:
                $event->setResponse(ExceptionJsonResponse::fromException($exception));
        }
    }

    private function violationResponseFromUnexpectedValue(NotNormalizableValueException $exception): ViolationsJsonResponse
    {
        return ViolationsJsonResponse::fromList(
            new ConstraintViolationList([
                new ConstraintViolation(
                    sprintf('This value should be of type %s.', $exception->getExpectedTypes()[0]),
                    null,
                    [],
                    null,
                    $exception->getPath(),
                    null
                ),
            ])
        );
    }
}
