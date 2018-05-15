<?php

namespace Naviapps\Bundle\DirectoryBundle\Model;

interface PostcodeInterface
{
    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set region
     *
     * @param RegionInterface|null $region
     *
     * @return PostcodeInterface
     */
    public function setRegion(?RegionInterface $region): PostcodeInterface;

    /**
     * Get region
     *
     * @return RegionInterface|null
     */
    public function getRegion(): ?RegionInterface;

    /**
     * Set code
     *
     * @param string|null $code
     *
     * @return PostcodeInterface
     */
    public function setCode(?string $code): PostcodeInterface;

    /**
     * Get code
     *
     * @return string|null
     */
    public function getCode(): ?string;
}
