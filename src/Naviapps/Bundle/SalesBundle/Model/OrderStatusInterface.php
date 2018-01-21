<?php

namespace Naviapps\Bundle\SalesBundle\Model;

interface OrderStatusInterface
{
    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set code
     *
     * @param string|null $code
     *
     * @return OrderStatusInterface
     */
    public function setCode(?string $code): OrderStatusInterface;

    /**
     * Get code
     *
     * @return string|null
     */
    public function getCode(): ?string;

    /**
     * Set name
     *
     * @param string|null $name
     *
     * @return OrderStatusInterface
     */
    public function setName(?string $name): OrderStatusInterface;

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set position
     *
     * @param int|null $position
     *
     * @return OrderStatusInterface
     */
    public function setPosition(?int $position): OrderStatusInterface;

    /**
     * Get position
     *
     * @return int|null
     */
    public function getPosition(): ?int;
}
