<?php

namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function create(User $user): void;

    public function isExists(string $id, string $login): bool;
}