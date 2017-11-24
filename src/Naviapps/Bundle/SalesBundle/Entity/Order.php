<?php

namespace Naviapps\Bundle\SalesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Naviapps\Bundle\CustomerBundle\Entity\Customer;

/**
 * @ORM\Entity(repositoryClass="Naviapps\Bundle\SalesBundle\Repository\OrderRepository")
 * @ORM\Table(name="sales_order")
 */
class Order
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
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="Naviapps\Bundle\CustomerBundle\Entity\Customer")
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
     * @param Customer $customer
     *
     * @return Order
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
