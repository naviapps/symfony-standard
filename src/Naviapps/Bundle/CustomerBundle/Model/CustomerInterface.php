<?php

namespace Naviapps\Bundle\CustomerBundle\Model;

use FOS\UserBundle\Model\UserInterface;

interface CustomerInterface extends UserInterface
{
    /**
     * Set emailRequestAt
     *
     * @param \DateTime|null $emailRequestAt
     *
     * @return CustomerInterface
     */
    public function setEmailRequestedAt(?\DateTime $emailRequestAt): CustomerInterface;

    /**
     * Get emailRequestAt
     *
     * @return \DateTime
     */
    public function getEmailRequestedAt(): \DateTime;

    /**
     * Set confirmationEmail
     *
     * @param null|string $confirmationEmail
     *
     * @return CustomerInterface
     */
    public function setConfirmationEmail(?string $confirmationEmail): CustomerInterface;

    /**
     * Get confirmationEmail
     *
     * @return string
     */
    public function getConfirmationEmail(): string;
}
