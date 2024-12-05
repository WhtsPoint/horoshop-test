<?php

namespace App\Service;

use App\Dto\LoginDto;
use App\Dto\UserDto;
use App\Exception\UserNotFoundException;
use App\JWT\JWT;
use App\Repository\UserRepositoryInterface;

final readonly class AuthService
{
    public function __construct(
        private JWT $JWT,
        private UserRepositoryInterface $repository,
        private int $tokenLifeTimeMs = 360000
    ) {
    }

    /**
     * @throws UserNotFoundException
     */
    public function login(LoginDto $dto): string
    {
        $user = $this->repository->readByLoginAndPass($dto->login, $dto->pass);

        return $this->JWT->createToken([
            'id' => $user->id,
            'role' => $this->getRole($user),
            'exp' => time() + $this->tokenLifeTimeMs
        ]);
    }

    private function getRole(UserDto $dto): string
    {
        return $dto->id === '1' ? 'testAdmin' : 'testUser';
    }
}