<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\Dive;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class DiveVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    /**
     * @param string $attribute An attribute
     * @param mixed  $subject   The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Dive) {
            return false;
        }

        return true;
    }

    /**
     * @param mixed $subject
     *
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /**
         * @var Dive
         */
        $dive = $subject;

        return $user->hasRoles('ROLE_ADMIN') || $user === $dive->getOwner();
    }
}
