<?php

namespace AppBundle\Security;

use AppBundle\Entity\SalesOrder;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class SalesOrderVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject): bool
    {
        return $subject instanceof SalesOrder && in_array($attribute, [self::EDIT, self::DELETE], true);
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        return true;
    }
}
