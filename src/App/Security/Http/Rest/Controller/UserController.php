<?php

declare(strict_types=1);

namespace App\Security\Http\Rest\Controller;

use App\Security\Http\Rest\Dto\RegisterUserDto;
use App\Security\Http\Rest\ViewModel\UserView;
use App\Shared\Adapter\CommandBus;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Security\Application\Command\CreateAUser\CreateAUserCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/users', name: 'users_')]
readonly class UserController
{
    public function __construct(
        private SerializerInterface $serializer,
        private CommandBus $commandBus,
        private ValidatorInterface $validator
    ) {}

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $registerUserDto = $this->serializer->deserialize($request->getContent(), RegisterUserDto::class, 'json');

        $violations = $this->validator->validate($registerUserDto);
        if (0 !== $violations->count()) {
            throw new ValidationFailedException($registerUserDto, $violations);
        }

        $command = new CreateAUserCommand(
            (new Version4Generator())->generate(),
            $registerUserDto->getUsername(),
            $registerUserDto->getEmail(),
            $registerUserDto->getPassword(),
            $registerUserDto->getRoles()
        );
        $this->commandBus->dispatch($command);

        return new JsonResponse(UserView::fromCreateUserCommand($command)->toArray(), Response::HTTP_OK);
    }
}
