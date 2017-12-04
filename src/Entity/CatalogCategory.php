<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class CatalogCategory
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\CatalogProduct", inversedBy="categories")
     * @ORM\JoinTable(name="catalog_category_product",
     *     joinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     * )
     */
    private $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

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
     * Add product
     *
     * @param CatalogProduct $product
     *
     * @return CatalogCategory
     */
    public function addProduct(CatalogProduct $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param CatalogProduct $product
     */
    public function removeProduct(CatalogProduct $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return Collection
     */
    public function getProducts()
    {
        return $this->products;
    }
}
