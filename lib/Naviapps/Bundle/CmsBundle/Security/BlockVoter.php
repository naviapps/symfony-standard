<?php

namespace Naviapps\Bundle\CmsBundle\Security;

use Naviapps\Bundle\CmsBundle\Entity\Block;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BlockVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject): bool
    {
        return $subject instanceof Block && in_array($attribute, [self::EDIT, self::DELETE], true);
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        return true;
    }
}
