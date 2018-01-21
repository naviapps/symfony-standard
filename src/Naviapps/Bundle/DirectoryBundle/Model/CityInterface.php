<?php

namespace Naviapps\Bundle\DirectoryBundle\Model;

interface CityInterface
{
    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set name
     *
     * @param string|null $name
     *
     * @return CityInterface
     */
    public function setName(?string $name): CityInterface;

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string;
}
