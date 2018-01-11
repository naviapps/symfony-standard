<?php

namespace Naviapps\Bundle\DirectoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Naviapps\Bundle\DirectoryBundle\Model\CountryInterface;
use Naviapps\Bundle\DirectoryBundle\Model\RegionInterface;

/**
 * @ORM\Entity(repositoryClass="Naviapps\Bundle\DirectoryBundle\Repository\RegionRepository")
 */
class Region implements RegionInterface
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @var CountryInterface|null
     *
     * @ORM\ManyToOne(targetEntity="Naviapps\Bundle\DirectoryBundle\Entity\Country")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

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
    public function setCountry(?CountryInterface $country): RegionInterface
    {
        $this->country = $country;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry(): ?CountryInterface
    {
        return $this->country;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(?string $name): RegionInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}
