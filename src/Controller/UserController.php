<?php

namespace App\Controller;

use App\Dto\UserCreationDto;
use App\Dto\UserReplaceDto;
use App\Exception\UserAlreadyExistsException;
use App\Exception\UserNotFoundException;
use App\Repository\UserRepositoryInterface;
use App\Service\UserCanBeReplaced;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/v1/user')]
final class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly UserService $service
    ) {
    }

    #[Route(methods: 'POST')]
    public function create(#[MapRequestPayload] UserCreationDto $dto): JsonResponse
    {
        try {
            $response = $this->service->create($dto);
        } catch (UserAlreadyExistsException) {
            throw new HttpException(400, 'User with this id, login or pass is already exists');
        }

        return $this->json($response, 201);
    }

    #[Route(path: '/{id}', methods: 'GET')]
    #[IsGranted('OWNER_OR_ADMIN', 'id')]
    public function get(string $id): JsonResponse
    {
        try {
            $response = $this->repository->read($id);
        } catch (UserNotFoundException) {
            throw new HttpException(404, 'User not found');
        }

        return $this->json($response);
    }

    #[Route(methods: 'PUT')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function update(#[MapRequestPayload] UserReplaceDto $dto): JsonResponse
    {
        try {
            $response = $this->service->replace($dto, new UserCanBeReplaced($this->getUser()));
        } catch (UserNotFoundException) {
            throw new HttpException(404, 'User not found');
        } catch (UserAlreadyExistsException) {
            throw new HttpException(400, 'User with this login and pass is already exists');
        }

        return $this->json(['id' => $response]);
    }

    #[Route(path: '/{id}', methods: 'DELETE')]
    #[IsGranted('IS_ADMIN')]
    public function delete(string $id): Response
    {
        try {
            $this->service->delete($id);
        } catch (UserNotFoundException) {
            throw new HttpException(404, 'User not found');
        }

        return new Response(status: 204);
    }
}