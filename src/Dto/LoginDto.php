<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints\NotBlank;

readonly class LoginDto
{
    public function __construct(
        #[NotBlank]
        public string $login,
        #[NotBlank]
        public string $pass
    ) {
    }
}