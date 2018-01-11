<?php

namespace Naviapps\Bundle\CatalogBundle\Model;

use Doctrine\Common\Collections\Collection;

interface CategoryInterface
{
    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set parent
     *
     * @param CategoryInterface|null $parent
     *
     * @return CategoryInterface
     */
    public function setParent(?CategoryInterface $parent): CategoryInterface;

    /**
     * Get parent
     *
     * @return CategoryInterface|null
     */
    public function getParent(): ?CategoryInterface;

    /**
     * Add child
     *
     * @param CategoryInterface $child
     *
     * @return CategoryInterface
     */
    public function addChild(CategoryInterface $child): CategoryInterface;

    /**
     * Remove child
     *
     * @param CategoryInterface $child
     */
    public function removeChild(CategoryInterface $child): void;

    /**
     * Get children
     *
     * @return Collection
     */
    public function getChildren(): Collection;

    /**
     * Set path
     *
     * @param string|null $path
     *
     * @return CategoryInterface
     */
    public function setPath(?string $path): CategoryInterface;

    /**
     * Get path
     *
     * @return string|null
     */
    public function getPath(): ?string;

    /**
     * Set position
     *
     * @param int|null $position
     *
     * @return CategoryInterface
     */
    public function setPosition(?int $position): CategoryInterface;

    /**
     * Get position
     *
     * @return int|null
     */
    public function getPosition(): ?int;

    /**
     * Set level
     *
     * @param int|null $level
     *
     * @return CategoryInterface
     */
    public function setLevel(?int $level): CategoryInterface;

    /**
     * Get level
     *
     * @return int|null
     */
    public function getLevel(): ?int;

    /**
     * Add product
     *
     * @param ProductInterface $product
     *
     * @return CategoryInterface
     */
    public function addProduct(ProductInterface $product): CategoryInterface;

    /**
     * Remove product
     *
     * @param ProductInterface $product
     */
    public function removeProduct(ProductInterface $product): void;

    /**
     * Get products
     *
     * @return Collection
     */
    public function getProducts(): Collection;

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CategoryInterface
     */
    public function setCreatedAt(\DateTime $createdAt): CategoryInterface;

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
     * @return CategoryInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt): CategoryInterface;

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;
}
