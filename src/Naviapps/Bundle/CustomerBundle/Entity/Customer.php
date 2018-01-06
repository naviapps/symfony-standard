<?php

namespace Naviapps\Bundle\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Naviapps\Bundle\CustomerBundle\Model\CustomerInterface;

/**
 * @ORM\MappedSuperclass(repositoryClass="Naviapps\Bundle\CustomerBundle\Repository\CustomerRepository")
 */
abstract class Customer extends User implements CustomerInterface
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
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $confirmationEmail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $emailRequestedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

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
    public function getConfirmationEmail(): string
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
    public function getEmailRequestedAt(): \DateTime
    {
        return $this->emailRequestedAt;
    }
}
