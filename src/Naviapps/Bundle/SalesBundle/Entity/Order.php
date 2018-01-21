<?php

namespace Naviapps\Bundle\SalesBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Naviapps\Bundle\CustomerBundle\Model\CustomerInterface;
use Naviapps\Bundle\SalesBundle\Model\OrderInterface;
use Naviapps\Bundle\SalesBundle\Model\OrderItemInterface;
use Naviapps\Bundle\SalesBundle\Model\OrderStatusInterface;

/**
 * @ORM\MappedSuperclass(repositoryClass="Naviapps\Bundle\SalesBundle\Repository\OrderRepository")
 */
abstract class Order implements OrderInterface
{
    const NUM_ITEMS = 10;

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    protected $id;

    /**
     * @var OrderStatusInterface|null
     *
     * @ORM\ManyToOne(targetEntity="Naviapps\Bundle\SalesBundle\Entity\OrderStatus")
     */
    protected $status;

    /**
     * @var CustomerInterface|null
     *
     * @ORM\ManyToOne(targetEntity="Naviapps\Bundle\CustomerBundle\Model\CustomerInterface")
     */
    protected $customer;

    /**
     * @var string|null
     *
     * @ORM\Column(type="decimal", precision=12, scale=4, nullable=true)
     */
    protected $grandTotal;

    /**
     * @var string|null
     *
     * @ORM\Column(type="decimal", precision=12, scale=4, nullable=true)
     */
    protected $subtotal;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $customerNote;

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
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Naviapps\Bundle\SalesBundle\Entity\OrderItem", mappedBy="order", cascade={"persist", "remove"})
     */
    protected $items;

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
    public function setStatus(?OrderStatusInterface $status): OrderInterface
    {
        $this->status = $status;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus(): ?OrderStatusInterface
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomer(?CustomerInterface $customer): OrderInterface
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    /**
     * {@inheritdoc}
     */
    public function setGrandTotal(?string $grandTotal): OrderInterface
    {
        $this->grandTotal = $grandTotal;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGrandTotal(): ?string
    {
        return $this->grandTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubtotal(?string $subtotal): OrderInterface
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubtotal(): ?string
    {
        return $this->subtotal;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomerNote(?string $customerNote): OrderInterface
    {
        $this->customerNote = $customerNote;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerNote(): ?string
    {
        return $this->customerNote;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt): OrderInterface
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
    public function setUpdatedAt(\DateTime $updatedAt): OrderInterface
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

    /**
     * {@inheritdoc}
     */
    public function addItem(OrderItemInterface $item): OrderInterface
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeItem(OrderItemInterface $item): void
    {
        $this->items->removeElement($item);
    }

    /**
     * {@inheritdoc}
     */
    public function getItems(): Collection
    {
        return $this->items;
    }
}
