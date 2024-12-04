<?php

namespace App\Controller;

use App\Dto\UserCreationDto;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api/user')]
final class UserController extends AbstractController
{
    public function __construct(
        private readonly UserService $service
    ) {
    }

    #[Route(path: '/', methods: 'POST')]
    public function create(#[MapQueryParameter] UserCreationDto $dto): JsonResponse
    {
        $this->service->create($dto);

        return $this->json(['status' => 'ok'], 201);
    }
}