<?php

namespace Naviapps\Bundle\SalesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Naviapps\Bundle\SalesBundle\Model\OrderStatusInterface;

/**
 * @ORM\Entity(repositoryClass="Naviapps\Bundle\SalesBundle\Repository\OrderStatusRepository")
 */
class OrderStatus implements OrderStatusInterface
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
     * @ORM\Column(type="string", length=32, unique=true)
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

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
    public function setCode(?string $code): OrderStatusInterface
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

    /**
     * {@inheritdoc}
     */
    public function setName(?string $name): OrderStatusInterface
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

    /**
     * {@inheritdoc}
     */
    public function setPosition(?int $position): OrderStatusInterface
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
