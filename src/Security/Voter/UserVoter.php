<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\User;

class UserVoter extends Voter
{
    public const USER_EDIT = 'USER_EDIT';
    public const USER_DELETE = 'USER_DELETE';

    protected function supports(string $attribute, $targeted_user): bool
    {
        return in_array($attribute, [self::USER_EDIT, self::USER_DELETE])
            && $targeted_user instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $targeted_user, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::USER_EDIT:
                return $this->canEdit($targeted_user, $user);
                break;
            case self::USER_DELETE:
                return $this->canDelete($targeted_user, $user);
                break;
        }

        return false;
    }

    private function canEdit(User $targeted_user, User $user)
    {
        if (
            $user === $targeted_user ||
            $user->hasRole('ROLE_SUPER_ADMIN') ||
            ($user->hasRole('ROLE_ADMIN') &&
                !($targeted_user->hasRole('ROLE_ADMIN') || $targeted_user->hasRole('ROLE_SUPER_ADMIN'))
            )
        ) {
            return true;
        }

        return false;
    }

    private function canDelete(User $targeted_user, User $user)
    {
        if (
            $user === $targeted_user ||
            $user->hasRole('ROLE_SUPER_ADMIN') ||
            ($user->hasRole('ROLE_ADMIN') &&
                !($targeted_user->hasRole('ROLE_ADMIN') || $targeted_user->hasRole('ROLE_SUPER_ADMIN'))
            )
        ) {
            return true;
        }

        return false;
    }
}
