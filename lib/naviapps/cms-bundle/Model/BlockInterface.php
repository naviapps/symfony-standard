<?php

namespace Naviapps\Bundle\CmsBundle\Model;

interface BlockInterface
{
    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set title
     *
     * @param string|null $title
     *
     * @return BlockInterface
     */
    public function setTitle(?string $title): BlockInterface;

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return BlockInterface
     */
    public function setCreatedAt(\DateTime $createdAt): BlockInterface;

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
     * @return BlockInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt): BlockInterface;

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;
}
