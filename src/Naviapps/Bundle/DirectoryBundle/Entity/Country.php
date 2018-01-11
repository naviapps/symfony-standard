<?php

namespace Naviapps\Bundle\DirectoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Naviapps\Bundle\DirectoryBundle\Model\CountryInterface;

/**
 * @ORM\Entity(repositoryClass="Naviapps\Bundle\DirectoryBundle\Repository\CountryRepository")
 */
class Country implements CountryInterface
{
}
