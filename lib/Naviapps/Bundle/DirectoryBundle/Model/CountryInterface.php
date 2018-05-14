<?php

namespace Naviapps\Bundle\DirectoryBundle\Model;

interface CountryInterface
{
    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set iso2Code
     *
     * @param string|null $iso2Code
     *
     * @return CountryInterface
     */
    public function setIso2Code(?string $iso2Code): CountryInterface;

    /**
     * Get iso2Code
     *
     * @return string|null
     */
    public function getIso2Code(): ?string;

    /**
     * Set iso3Code
     *
     * @param string|null $iso3Code
     *
     * @return CountryInterface
     */
    public function setIso3Code(?string $iso3Code): CountryInterface;

    /**
     * Get iso3Code
     *
     * @return string|null
     */
    public function getIso3Code(): ?string;

    /**
     * Set position
     *
     * @param int|null $position
     *
     * @return CountryInterface
     */
    public function setPosition(?int $position): CountryInterface;

    /**
     * Get position
     *
     * @return int|null
     */
    public function getPosition(): ?int;
}
