<?php

namespace App\Service;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class UserCanBeReplaced implements CanBeReplacedInterface
{
    public function __construct(private UserInterface $authUser) {
    }

    public function validate(string $id): void
    {
        if (
            $this->authUser->getUserIdentifier() !== $id
            && in_array('testAdmin', $this->authUser->getRoles(), true) === false
        ) {
            throw new AccessDeniedException();
        }
    }
}