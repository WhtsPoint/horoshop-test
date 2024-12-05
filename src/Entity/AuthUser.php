<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

readonly class AuthUser implements UserInterface
{
    public function __construct(
        private string $id,
        private array $roles
    ) {
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->id;
    }
}