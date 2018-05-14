<?php

namespace Naviapps\Bundle\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User;
use Gedmo\Mapping\Annotation as Gedmo;
use Naviapps\Bundle\CustomerBundle\Model\CustomerInterface;

/**
 * @ORM\MappedSuperclass(repositoryClass="Naviapps\Bundle\CustomerBundle\Repository\CustomerRepository")
 */
abstract class Customer extends User implements CustomerInterface
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
    protected $confirmationEmail;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $emailRequestedAt;

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
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        parent::setEmail($email);
        $this->setUsername($email);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfirmationEmail(?string $confirmationEmail): CustomerInterface
    {
        $this->confirmationEmail = $confirmationEmail;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfirmationEmail(): ?string
    {
        return $this->confirmationEmail;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailRequestedAt(?\DateTime $emailRequestAt): CustomerInterface
    {
        $this->emailRequestedAt = $emailRequestAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailRequestedAt(): ?\DateTime
    {
        return $this->emailRequestedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt): CustomerInterface
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
    public function setUpdatedAt(\DateTime $updatedAt): CustomerInterface
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
