<?php

namespace Naviapps\Bundle\CatalogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @Gedmo\Tree(type="materializedPath")
 * @ORM\MappedSuperclass(repositoryClass="Naviapps\Bundle\CatalogBundle\Repository\CategoryRepository")
 */
abstract class Category
{
    use TimestampableEntity;

    /**
     * @var integer
     *
     * @Gedmo\TreePathSource
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var integer
     *
     * @Gedmo\TreePath(separator="/", endsWithSeparator=false)
     * @ORM\Column(type="string", nullable=true)
     */
    protected $path;

    /**
     * @var Category
     *
     * @Gedmo\TreeParent
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Naviapps\Bundle\CatalogBundle\Entity\Category", inversedBy="children")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $parent;

    /**
     * @var integer
     *
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer", nullable=true, options={"unsigned": true})
     */
    protected $level;

    /**
     * @var integer
     *
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    protected $position;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Naviapps\Bundle\CatalogBundle\Entity\Category", mappedBy="parent")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $children;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Naviapps\Bundle\CatalogBundle\Entity\Product", inversedBy="categories")
     */
    protected $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Category
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set parent
     *
     * @param Category|null $parent
     *
     * @return Category
     */
    public function setParent(?Category $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Category
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Add child
     *
     * @param Category $child
     *
     * @return Category
     */
    public function addChild(Category $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param Category $child
     */
    public function removeChild(Category $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add product
     *
     * @param Product $product
     *
     * @return Category
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param Product $product
     */
    public function removeProduct(Product $product)
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
