<?php

namespace Naviapps\Bundle\SalesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Naviapps\Bundle\CustomerBundle\Model\CustomerInterface;

/**
 * @ORM\MappedSuperclass(repositoryClass="Naviapps\Bundle\SalesBundle\Repository\OrderRepository")
 */
abstract class Order
{
    use TimestampableEntity;

    const NUM_ITEMS = 10;

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @var CustomerInterface
     *
     * @ORM\ManyToOne(targetEntity="Naviapps\Bundle\CustomerBundle\Model\CustomerInterface")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set customer
     *
     * @param CustomerInterface $customer
     *
     * @return Order
     */
    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
