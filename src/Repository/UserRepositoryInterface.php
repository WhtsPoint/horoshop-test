<?php

namespace App\Repository;

use App\Dto\UserByIdDto;
use App\Dto\UserDto;
use App\Entity\User;
use App\Exception\UserNotFoundException;

interface UserRepositoryInterface
{
    public function create(User $user): void;

    public function delete(User $user): void;

    /**
     * @throws UserNotFoundException
     */
    public function get(string $id): User;

    /**
     * @throws UserNotFoundException
     * */
    public function getByLoginAndPass(string $login, string $pass): User;

    /**
     * @throws UserNotFoundException
     **/
    public function read(string $id): UserByIdDto;

    /**
     * @throws UserNotFoundException
     * */
    public function readByLoginAndPass(string $login, string $pass): UserDto;

    public function isExists(string $id, string $login, string $pass): bool;

    public function isExistsWithIdExclude(string $id, string $login, string $pass): bool;

}