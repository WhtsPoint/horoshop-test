<?php

namespace App\Service;

use App\Dto\UserCreationDto;
use App\Entity\User;
use App\Exception\UserAlreadyExistsException;
use App\Flusher\FlusherInterface;
use App\Repository\UserRepositoryInterface;
use App\ValueObject\UserProperty;

final readonly class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private FlusherInterface $flusher
    ) {
    }

    /**
     * @throws UserAlreadyExistsException
     */
    public function create(UserCreationDto $dto): void
    {
        if ($this->userRepository->isExists($dto->id, $dto->login)) {
            throw new UserAlreadyExistsException();
        }

        $user = new User(
            new UserProperty($dto->id),
            new UserProperty($dto->login),
            new UserProperty($dto->phone),
            new UserProperty($dto->password)
        );

        $this->userRepository->create($user);
        $this->flusher->flush();
    }
}