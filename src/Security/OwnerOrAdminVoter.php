<?php

namespace App\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class OwnerOrAdminVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === 'OWNER_OR_ADMIN';
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $roles = $token->getRoleNames();

        if (in_array('testAdmin', $roles, true) === true) {
            return true;
        }

        return $subject === $token->getUserIdentifier();
    }
}