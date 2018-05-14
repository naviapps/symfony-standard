<?php

namespace Naviapps\Bundle\CustomerBundle\Security;

use Naviapps\Bundle\CustomerBundle\Model\CustomerInterface;
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
        return $subject instanceof CustomerInterface && in_array($attribute, [self::EDIT, self::DELETE], true);
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        return true;
    }
}
