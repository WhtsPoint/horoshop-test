<?php

namespace App\ValueObject;

use InvalidArgumentException;

class UserProperty
{
    public const MAX_LENGTH = 8;
    public const MIN_LENGTH = 1;

    private string $value;

    public function __construct(string $value)
    {
        if (strlen($value) > self::MAX_LENGTH || strlen($value) < self::MIN_LENGTH) {
            throw new InvalidArgumentException('Invalid value length');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}