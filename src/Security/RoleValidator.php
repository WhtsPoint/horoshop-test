<?php

namespace App\Security;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class RoleValidator
{
    public function __construct(private UserInterface $authUser) {
    }

    public function validateOwnRecourseAccess(string $id): void
    {
        if ($this->isAdmin() === false && $this->authUser->getUserIdentifier() !== $id) {
            throw new HttpException(403, 'Can`t access not your data');
        }
    }

    private function isAdmin(): bool
    {
        return in_array('testAdmin', $this->authUser->getRoles());
    }
}