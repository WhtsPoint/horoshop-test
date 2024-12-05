<?php

namespace App\Service;

interface CanBeReplacedInterface
{
    public function validate(string $id): void;
}