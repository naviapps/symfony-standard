<?php

namespace Naviapps\Bundle\SalesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Naviapps\Bundle\CatalogBundle\Model\ProductInterface;
use Naviapps\Bundle\SalesBundle\Model\OrderInterface;
use Naviapps\Bundle\SalesBundle\Model\OrderItemInterface;

/**
 * @ORM\Entity(repositoryClass="Naviapps\Bundle\SalesBundle\Repository\OrderItemRepository")
 */
class OrderItem implements OrderItemInterface
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
     * @var OrderInterface
     *
     * @ORM\ManyToOne(targetEntity="Naviapps\Bundle\SalesBundle\Model\OrderInterface", inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $order;

    /**
     * @var ProductInterface|null
     *
     * @ORM\ManyToOne(targetEntity="Naviapps\Bundle\CatalogBundle\Model\ProductInterface")
     */
    private $product;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $sku;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

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
    public function setOrder(OrderInterface $order): OrderItemInterface
    {
        $this->order = $order;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder(): OrderInterface
    {
        return $this->order;
    }

    /**
     * {@inheritdoc}
     */
    public function setProduct(?ProductInterface $product): OrderItemInterface
    {
        $this->product = $product;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProduct(): ?ProductInterface
    {
        return $this->product;
    }

    /**
     * {@inheritdoc}
     */
    public function setSku(?string $sku): OrderItemInterface
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(?string $name): OrderItemInterface
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
    public function setCreatedAt(\DateTime $createdAt): OrderItemInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt): OrderItemInterface
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}
