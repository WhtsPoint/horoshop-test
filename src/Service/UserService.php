<?php

namespace App\Service;

use App\Dto\UserCreationDto;
use App\Dto\UserReplaceDto;
use App\Entity\User;
use App\Exception\UserAlreadyExistsException;
use App\Exception\UserNotFoundException;
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
    public function create(UserCreationDto $dto): User
    {
        if ($this->userRepository->isExists($dto->id, $dto->login, $dto->pass)) {
            throw new UserAlreadyExistsException();
        }

        $user = new User(
            new UserProperty($dto->id),
            new UserProperty($dto->login),
            new UserProperty($dto->phone),
            new UserProperty($dto->pass)
        );

        $this->userRepository->create($user);
        $this->flusher->flush();

        return $user;
    }

    /**
     * @throws UserNotFoundException
     * @throws UserAlreadyExistsException
     */
    public function replace(UserReplaceDto $dto, ?CanBeReplacedInterface $canBeReplaced = null): string
    {
        $user = $this->userRepository->getByLoginAndPass($dto->login, $dto->pass);

        $canBeReplaced?->validate($user->getId());

        if ($this->userRepository->isExistsWithIdExclude($user->getId(), $dto->login, $dto->pass)) {
            throw new UserAlreadyExistsException();
        }

        $user->setPhone(new UserProperty($dto->phone));
        $this->flusher->flush();

        return $user->getId();
    }

    /**
     * @throws UserNotFoundException
     */
    public function delete(string $id): void
    {
        $this->userRepository->delete(
            $this->userRepository->get($id)
        );

        $this->flusher->flush();
    }
}