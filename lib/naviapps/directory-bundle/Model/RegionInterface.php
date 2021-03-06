<?php

namespace Naviapps\Bundle\DirectoryBundle\Model;

interface RegionInterface
{
    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set country
     *
     * @param CountryInterface|null $country
     *
     * @return RegionInterface
     */
    public function setCountry(?CountryInterface $country): RegionInterface;

    /**
     * Get country
     *
     * @return CountryInterface|null
     */
    public function getCountry(): ?CountryInterface;

    /**
     * Set code
     *
     * @param string|null $code
     *
     * @return RegionInterface
     */
    public function setCode(?string $code): RegionInterface;

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
     * @return RegionInterface
     */
    public function setName(?string $name): RegionInterface;

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string;
}
