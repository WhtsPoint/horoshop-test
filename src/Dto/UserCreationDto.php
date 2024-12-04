<?php

namespace App\Dto;

use App\ValueObject\UserProperty;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class UserCreationDto
{
    public function __construct(
        #[NotBlank]
        #[Length(min: UserProperty::MIN_LENGTH, max: UserProperty::MAX_LENGTH)]
        public string $id,
        #[NotBlank]
        #[Length(min: UserProperty::MIN_LENGTH, max: UserProperty::MAX_LENGTH)]
        public string $login,
        #[NotBlank]
        #[Length(min: UserProperty::MIN_LENGTH, max: UserProperty::MAX_LENGTH)]
        public string $phone,
        #[NotBlank]
        #[Length(min: UserProperty::MIN_LENGTH, max: UserProperty::MAX_LENGTH)]
        public string $password
    ) {
    }
}