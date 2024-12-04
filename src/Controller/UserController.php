<?php

namespace App\Controller;

use App\Dto\UserCreationDto;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    public function __construct(
        private readonly UserService $service
    ) {
    }

    #[Route(path: '/api/user', methods: 'POST')]
    public function create(#[MapRequestPayload] UserCreationDto $dto): JsonResponse
    {
        $this->service->create($dto);

        return $this->json(['status' => 'ok'], 201);
    }
}