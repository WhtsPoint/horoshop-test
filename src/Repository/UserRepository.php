<?php

namespace App\Repository;

use App\Dto\UserByIdDto;
use App\Dto\UserDto;
use App\Entity\User;
use App\Exception\UserNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

final class UserRepository implements UserRepositoryInterface
{
    private EntityRepository $entityRepository;

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
        $this->entityRepository = $entityManager->getRepository(User::class);
    }

    public function create(User $user): void
    {
        $this->entityManager->persist($user);
    }

    public function isExists(string $id, string $login, string $pass): bool
    {
        $query = $this->entityManager->createQuery(
            'SELECT COUNT(u.id) as c FROM App\Entity\User as u WHERE u.id = :id OR (u.login = :login AND u.pass = :pass)'
        );

        $query->setParameters(['id' => $id, 'login' => $login, 'pass' => $pass]);

        [['c' => $count]] = $query->getScalarResult();

        return $count !== 0;
    }

    public function read(string $id): UserByIdDto
    {
        $query = $this->entityManager->createQuery(
            'SELECT NEW App\Dto\UserByIdDto(u.login, u.phone, u.pass) FROM App\Entity\User as u WHERE u.id = :id'
        );

        $query->setParameter('id', $id);

        try {
            $dto = $query->getSingleResult();
        } catch (NoResultException) {
            throw new UserNotFoundException();
        }

        return $dto;
    }

    public function getByLoginAndPass(string $login, string $pass): User
    {
        $user = $this->entityRepository->findOneBy(['login' => $login, 'pass' => $pass]);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
    }

    public function get(string $id): User
    {
        $user = $this->entityRepository->findOneBy(['id' => $id]);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function isExistsWithIdExclude(string $id, string $login, string $pass): bool
    {
        $query = $this->entityManager->createQuery(
            'SELECT COUNT(u.id) as c FROM App\Entity\User as u WHERE u.id <> :id AND u.login = :login AND u.pass = :pass'
        );

        $query->setParameters(['id' => $id, 'login' => $login, 'pass' => $pass]);

        [['c' => $count]] = $query->getScalarResult();

        return $count !== 0;
    }

    /**
     * @throws UserNotFoundException
     */
    public function readByLoginAndPass(string $login, string $pass): UserDto
    {
        $query = $this->entityManager->createQuery(
            'SELECT NEW App\Dto\UserDto(u.login, u.phone, u.pass, u.id) FROM App\Entity\User as u WHERE u.login = :login AND u.pass = :pass'
        );

        $query->setParameters(['login' => $login, 'pass' => $pass]);

        try {
            $dto = $query->getSingleResult();
        } catch (NoResultException) {
            throw new UserNotFoundException();
        }

        return $dto;
    }
}