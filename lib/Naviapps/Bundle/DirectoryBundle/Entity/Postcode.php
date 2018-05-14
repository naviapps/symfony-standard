<?php

namespace Naviapps\Bundle\DirectoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Naviapps\Bundle\DirectoryBundle\Model\PostcodeInterface;
use Naviapps\Bundle\DirectoryBundle\Model\RegionInterface;

/**
 * @ORM\Entity(repositoryClass="Naviapps\Bundle\DirectoryBundle\Repository\PostcodeRepository")
 */
class Postcode implements PostcodeInterface
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
     * @var RegionInterface|null
     *
     * @ORM\ManyToOne(targetEntity="Naviapps\Bundle\DirectoryBundle\Entity\Region")
     */
    private $region;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $code;

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
    public function setRegion(?RegionInterface $region): PostcodeInterface
    {
        $this->region = $region;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRegion(): ?RegionInterface
    {
        return $this->region;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode(?string $code): PostcodeInterface
    {
        $this->code = $code;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode(): ?string
    {
        return $this->code;
    }
}
