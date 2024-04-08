<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    public function __construct(
        private readonly UserService $userService
    )
    {
    }

    #[Route('/me', name: 'me_get', methods: ['GET'])]
    public function getMeAction(): JsonResponse
    {
        return $this->json(
            $this->userService->me()
        );
    }

}