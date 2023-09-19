<?php

declare(strict_types=1);

namespace App\Home\Http\Rest\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AppController
{
    #[Route('/', name: 'home', methods: 'GET')]
    public function home(): JsonResponse
    {
        return new JsonResponse('Hello World !');
    }
}
