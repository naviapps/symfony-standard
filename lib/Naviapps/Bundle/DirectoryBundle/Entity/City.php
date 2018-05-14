<?php

namespace Naviapps\Bundle\DirectoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Naviapps\Bundle\DirectoryBundle\Model\CityInterface;

/**
 * @ORM\Entity(repositoryClass="Naviapps\Bundle\DirectoryBundle\Repository\CityRepository")
 */
class City implements CityInterface
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
    public function setName(?string $name): CityInterface
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
