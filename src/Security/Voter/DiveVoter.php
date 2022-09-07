<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\User;
use App\Entity\Dive;

class DiveVoter extends Voter
{
    public const DIVE_EDIT = 'DIVE_EDIT';
    public const DIVE_DELETE = 'DIVE_DELETE';

    protected function supports(string $attribute, $dive): bool
    {
        return in_array($attribute, [self::DIVE_EDIT, self::DIVE_DELETE])
            && $dive instanceof \App\Entity\Dive;
    }

    protected function voteOnAttribute(string $attribute, $dive, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (null === $dive->getOwner()) {
            return false;
        }

        switch ($attribute) {
            case self::DIVE_EDIT:
                return $this->canEdit($dive, $user);
                break;
            case self::DIVE_DELETE:
                return $this->canDelete($dive, $user);
                break;
        }

        return false;
    }

    private function canEdit(Dive $dive, User $user)
    {
        if ($user === $dive->getOwner() || $user->hasRoles('ROLE_ADMIN')) {
            return true;
        }

        return false;
    }

    private function canDelete(Dive $dive, User $user)
    {
        if ($user === $dive->getOwner() || $user->hasRoles('ROLE_ADMIN')) {
            return true;
        }

        return false;
    }
}
