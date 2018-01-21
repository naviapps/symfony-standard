<?php

namespace Naviapps\Bundle\SalesBundle\Model;

use Naviapps\Bundle\CatalogBundle\Model\ProductInterface;

interface OrderItemInterface
{
    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set order
     *
     * @param OrderInterface $order
     *
     * @return OrderItemInterface
     */
    public function setOrder(OrderInterface $order): OrderItemInterface;

    /**
     * Get order
     *
     * @return OrderInterface
     */
    public function getOrder(): OrderInterface;

    /**
     * Set product
     *
     * @param ProductInterface|null $product
     *
     * @return OrderItemInterface
     */
    public function setProduct(?ProductInterface $product): OrderItemInterface;

    /**
     * Get product
     *
     * @return ProductInterface|null
     */
    public function getProduct(): ?ProductInterface;

    /**
     * Set sku
     *
     * @param string|null $sku
     *
     * @return OrderItemInterface
     */
    public function setSku(?string $sku): OrderItemInterface;

    /**
     * Get sku
     *
     * @return string|null
     */
    public function getSku(): ?string;

    /**
     * Set name
     *
     * @param string|null $name
     *
     * @return OrderItemInterface
     */
    public function setName(?string $name): OrderItemInterface;

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return OrderItemInterface
     */
    public function setCreatedAt(\DateTime $createdAt): OrderItemInterface;

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
     * @return OrderItemInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt): OrderItemInterface;

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;
}
