<?php

namespace App\Dto;

readonly class UserDto
{
    public function __construct(
        public string $login,
        public string $phone,
        public string $pass,
        public string $id
    ) {
    }
}