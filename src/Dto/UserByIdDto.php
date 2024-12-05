<?php

namespace App\Dto;

readonly class UserByIdDto
{
    public function __construct(
        public string $login,
        public string $phone,
        public string $pass
    ) {
    }
}