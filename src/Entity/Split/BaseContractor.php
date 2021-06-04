<?php

namespace Evrinoma\ContractorBundle\Entity\Split;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ContractorBundle\Model\Split\AbstractContractor;

/**
 * BaseContractor
 *
 * @ORM\Table(name="contractor")
 * @ORM\Entity(repositoryClass="Evrinoma\ContractorBundle\Repository\ContractorRepository")
 */
final class BaseContractor extends AbstractContractor
{
}