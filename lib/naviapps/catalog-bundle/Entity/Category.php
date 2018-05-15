<?php

namespace Naviapps\Bundle\CatalogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Naviapps\Bundle\CatalogBundle\Model\CategoryInterface;
use Naviapps\Bundle\CatalogBundle\Model\ProductInterface;

/**
 * @Gedmo\Tree(type="materializedPath")
 * @ORM\MappedSuperclass(repositoryClass="Naviapps\Bundle\CatalogBundle\Repository\CategoryRepository")
 */
abstract class Category implements CategoryInterface
{
    /**
     * @var int|null
     *
     * @Gedmo\TreePathSource
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    protected $id;

    /**
     * @var CategoryInterface|null
     *
     * @Gedmo\TreeParent
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Naviapps\Bundle\CatalogBundle\Model\CategoryInterface", inversedBy="children")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $parent;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Naviapps\Bundle\CatalogBundle\Model\CategoryInterface", mappedBy="parent")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $children;

    /**
     * @var string|null
     *
     * @Gedmo\TreePath(separator="/", endsWithSeparator=false)
     * @ORM\Column(type="string", nullable=true)
     */
    protected $path;

    /**
     * @var int|null
     *
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    protected $position;

    /**
     * @var int|null
     *
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer", nullable=true, options={"unsigned": true})
     */
    protected $level;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Naviapps\Bundle\CatalogBundle\Model\ProductInterface", inversedBy="categories")
     */
    protected $products;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

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
    public function setParent(?CategoryInterface $parent): CategoryInterface
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): ?CategoryInterface
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(CategoryInterface $child): CategoryInterface
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeChild(CategoryInterface $child): void
    {
        $this->children->removeElement($child);
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function setPath(?string $path): CategoryInterface
    {
        $this->path = $path;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function setPosition(?int $position): CategoryInterface
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

    /**
     * {@inheritdoc}
     */
    public function setLevel(?int $level): CategoryInterface
    {
        $this->level = $level;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLevel(): ?int
    {
        return $this->level;
    }

    /**
     * {@inheritdoc}
     */
    public function addProduct(ProductInterface $product): CategoryInterface
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(ProductInterface $product): void
    {
        $this->products->removeElement($product);
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt): CategoryInterface
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
    public function setUpdatedAt(\DateTime $updatedAt): CategoryInterface
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
