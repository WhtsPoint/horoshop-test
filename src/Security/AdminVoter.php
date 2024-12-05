<?php

namespace App\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AdminVoter extends Voter
{

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === 'IS_ADMIN';
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        return in_array('testAdmin', $token->getRoleNames());
    }
}