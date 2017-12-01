<?php

namespace AppBundle\Security;

use AppBundle\Entity\Customer;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CustomerVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject): bool
    {
        return $subject instanceof Customer && in_array($attribute, [self::EDIT, self::DELETE], true);
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        return true;
    }
}
