<?php

namespace Naviapps\Bundle\CatalogBundle\Model;

use Doctrine\Common\Collections\Collection;

interface ProductInterface
{
    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Add category
     *
     * @param CategoryInterface $category
     *
     * @return ProductInterface
     */
    public function addCategory(CategoryInterface $category): ProductInterface;

    /**
     * Remove category
     *
     * @param CategoryInterface $category
     */
    public function removeCategory(CategoryInterface $category): void;

    /**
     * Get categories
     *
     * @return Collection
     */
    public function getCategories(): Collection;

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ProductInterface
     */
    public function setCreatedAt(\DateTime $createdAt): ProductInterface;

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
     * @return ProductInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt): ProductInterface;

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;
}
