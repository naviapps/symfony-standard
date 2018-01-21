<?php

namespace Naviapps\Bundle\SalesBundle\Model;

use Doctrine\Common\Collections\Collection;
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
     * Set status
     *
     * @param OrderStatusInterface|null $status
     *
     * @return OrderInterface
     */
    public function setStatus(?OrderStatusInterface $status): OrderInterface;

    /**
     * Get status
     *
     * @return OrderStatusInterface|null
     */
    public function getStatus(): ?OrderStatusInterface;

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
     * Set grandTotal
     *
     * @param string|null $grandTotal
     *
     * @return OrderInterface
     */
    public function setGrandTotal(?string $grandTotal): OrderInterface;

    /**
     * Get grandTotal
     *
     * @return string|null
     */
    public function getGrandTotal(): ?string;

    /**
     * Set subtotal
     *
     * @param string|null $subtotal
     *
     * @return OrderInterface
     */
    public function setSubtotal(?string $subtotal): OrderInterface;

    /**
     * Get subtotal
     *
     * @return string|null
     */
    public function getSubtotal(): ?string;

    /**
     * Set customerNote
     *
     * @param string|null $customerNote
     *
     * @return OrderInterface
     */
    public function setCustomerNote(?string $customerNote): OrderInterface;

    /**
     * Get customerNote
     *
     * @return string|null
     */
    public function getCustomerNote(): ?string;

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

    /**
     * Add item
     *
     * @param OrderItemInterface $item
     *
     * @return OrderInterface
     */
    public function addItem(OrderItemInterface $item): OrderInterface;

    /**
     * Remove item
     *
     * @param OrderItemInterface $item
     */
    public function removeItem(OrderItemInterface $item): void;

    /**
     * Get items
     *
     * @return Collection
     */
    public function getItems(): Collection;
}
