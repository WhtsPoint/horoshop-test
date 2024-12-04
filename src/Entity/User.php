<?php

namespace App\Entity;

use App\ValueObject\UserProperty;

final class User
{
    public function __construct(
        private readonly UserProperty $id,
        private UserProperty $login,
        private UserProperty $phone,
        private UserProperty $pass
    ) {
    }

    public function getId(): UserProperty
    {
        return $this->id;
    }

    public function getLogin(): UserProperty
    {
        return $this->login;
    }

    public function setLogin(UserProperty $login): void
    {
        $this->login = $login;
    }

    public function getPhone(): UserProperty
    {
        return $this->phone;
    }

    public function setPhone(UserProperty $phone): void
    {
        $this->phone = $phone;
    }

    public function getPass(): UserProperty
    {
        return $this->pass;
    }

    public function setPass(UserProperty $password): void
    {
        $this->pass = $password;
    }
}