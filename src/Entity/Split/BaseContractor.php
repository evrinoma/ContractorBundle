<?php

namespace Evrinoma\ContractorBundle\Entity\Split;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ContractorBundle\Model\Split\AbstractContractor;

/**
 * BaseContractor
 *
 * @ORM\Table(name="e_contractor")
 * @ORM\Entity(repositoryClass="Evrinoma\ContractorBundle\Repository\ContractorRepository")
 */
class BaseContractor extends AbstractContractor
{
}