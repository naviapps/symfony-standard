<?php

namespace Naviapps\Bundle\DirectoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Naviapps\Bundle\DirectoryBundle\Model\CountryInterface;

/**
 * @ORM\Entity(repositoryClass="Naviapps\Bundle\DirectoryBundle\Repository\CountryRepository")
 */
class Country implements CountryInterface
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="smallint", options={"unsigned": true})
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=2, unique=true)
     */
    private $iso2Code;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=3, unique=true)
     */
    private $iso3Code;

    /**
     * @var int|null
     *
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setIso2Code(?string $iso2Code): CountryInterface
    {
        $this->iso2Code = $iso2Code;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIso2Code(): ?string
    {
        return $this->iso2Code;
    }

    /**
     * {@inheritdoc}
     */
    public function setIso3Code(?string $iso3Code): CountryInterface
    {
        $this->iso3Code = $iso3Code;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIso3Code(): ?string
    {
        return $this->iso3Code;
    }

    /**
     * {@inheritdoc}
     */
    public function setPosition(?int $position): CountryInterface
    {
        $this->position = $position;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }
}
