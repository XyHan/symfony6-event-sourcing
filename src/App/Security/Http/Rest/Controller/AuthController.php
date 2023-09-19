<?php

declare(strict_types=1);

namespace App\Security\Http\Rest\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AuthController
{
    #[Route('/login', name: 'api_login', methods: ['POST'])]
    public function login(#[CurrentUser] ?UserInterface $user, JWTTokenManagerInterface $JWTManager): Response
    {
        return new JsonResponse(['token' => $JWTManager->create($user)]);
    }

    #[Route('/logout', name: 'api_logout', methods: ['GET'])]
    public function logout(Security $security): Response
    {
        $security->logout();

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
