<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

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

    public function isExists(string $id, string $login): bool
    {
        return $this->entityRepository->count(['id' => $id, 'login' => $login]) > 0;
    }
}