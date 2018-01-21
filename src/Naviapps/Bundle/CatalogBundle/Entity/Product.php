<?php

namespace Naviapps\Bundle\CatalogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Naviapps\Bundle\CatalogBundle\Model\CategoryInterface;
use Naviapps\Bundle\CatalogBundle\Model\ProductInterface;

/**
 * @ORM\MappedSuperclass(repositoryClass="Naviapps\Bundle\CatalogBundle\Repository\ProductRepository")
 */
abstract class Product implements ProductInterface
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
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Naviapps\Bundle\CatalogBundle\Model\CategoryInterface", mappedBy="products")
     */
    protected $categories;

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
        $this->categories = new ArrayCollection();
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
    public function setName(?string $name): ProductInterface
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
    public function addCategory(CategoryInterface $category): ProductInterface
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeCategory(CategoryInterface $category): void
    {
        $this->categories->removeElement($category);
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt): ProductInterface
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
    public function setUpdatedAt(\DateTime $updatedAt): ProductInterface
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
