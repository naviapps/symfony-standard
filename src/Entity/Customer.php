<?php

namespace App\Entity;

use Naviapps\Bundle\CustomerBundle\Entity\Customer as BaseCustomer;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Customer extends BaseCustomer
{
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $googleId;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $googleAccessToken;

    /**
     * Set googleId
     *
     * @param string|null $googleId
     *
     * @return Customer
     */
    public function setGoogleId(?string $googleId): Customer
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string|null
     */
    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    /**
     * Set googleAccessToken
     *
     * @param string|null $googleAccessToken
     *
     * @return Customer
     */
    public function setGoogleAccessToken(?string $googleAccessToken): Customer
    {
        $this->googleAccessToken = $googleAccessToken;

        return $this;
    }

    /**
     * Get googleAccessToken
     *
     * @return string|null
     */
    public function getGoogleAccessToken(): ?string
    {
        return $this->googleAccessToken;
    }
}
