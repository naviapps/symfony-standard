<?php

namespace Naviapps\Bundle\CmsBundle\Model;

interface PageInterface
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
     * @return PageInterface
     */
    public function setTitle(?string $title): PageInterface;

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
     * @return PageInterface
     */
    public function setCreatedAt(\DateTime $createdAt): PageInterface;

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
     * @return PageInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt): PageInterface;

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;
}
