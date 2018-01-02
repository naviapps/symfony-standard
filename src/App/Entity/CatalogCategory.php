<?php

namespace App\Entity;

use Naviapps\Bundle\CatalogBundle\Entity\Category as BaseCategory;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\AssociationOverrides({
 *     @ORM\AssociationOverride(name="products",
 *         joinTable=@ORM\JoinTable(
 *             name="catalog_category_product",
 *             joinColumns={@ORM\JoinColumn(name="category_id")},
 *             inverseJoinColumns={@ORM\JoinColumn(name="product_id")}
 *         )
 *     )
 * })
 */
class CatalogCategory extends BaseCategory
{
}
