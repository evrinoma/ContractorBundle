<?php

namespace Evrinoma\ContractorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ContractorBundle\Model\AbstractContractor;

/**
 * BaseContractor
 *
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="Evrinoma\ContractorBundle\Repository\ContractorRepository")
 */
class BaseContractor extends AbstractContractor
{
}