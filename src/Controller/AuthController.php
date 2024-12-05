<?php

namespace App\Controller;

use App\Dto\LoginDto;
use App\Exception\UserNotFoundException;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends AbstractController
{
    public function __construct(
        private readonly AuthService $service
    ) {
    }

    #[Route('api/login', methods: 'GET')]
    public function login(#[MapRequestPayload] LoginDto $dto): JsonResponse
    {
        try {
            $token = $this->service->login($dto);
        } catch (UserNotFoundException) {
            throw new HttpException(400, 'Invalid credentials');
        }

        return new JsonResponse(['accessToken' => $token]);
    }
}