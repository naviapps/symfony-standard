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
     * @return \DateTime|null
     */
    public function getEmailRequestedAt(): ?\DateTime;

    /**
     * Set confirmationEmail
     *
     * @param string|null $confirmationEmail
     *
     * @return CustomerInterface
     */
    public function setConfirmationEmail(?string $confirmationEmail): CustomerInterface;

    /**
     * Get confirmationEmail
     *
     * @return string|null
     */
    public function getConfirmationEmail(): ?string;

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CustomerInterface
     */
    public function setCreatedAt(\DateTime $createdAt): CustomerInterface;

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return CustomerInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt): CustomerInterface;

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;
}
