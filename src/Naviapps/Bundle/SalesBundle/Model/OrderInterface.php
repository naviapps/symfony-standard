<?php

namespace Naviapps\Bundle\SalesBundle\Model;

use Naviapps\Bundle\CustomerBundle\Model\CustomerInterface;

interface OrderInterface
{
    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set customer
     *
     * @param CustomerInterface|null $customer
     *
     * @return OrderInterface
     */
    public function setCustomer(?CustomerInterface $customer): OrderInterface;

    /**
     * Get customer
     *
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface;

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return OrderInterface
     */
    public function setCreatedAt(\DateTime $createdAt): OrderInterface;

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
     * @return OrderInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt): OrderInterface;

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;
}
