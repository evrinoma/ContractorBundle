<?php

namespace Evrinoma\ContractorBundle\Entity\Split;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ContractorBundle\Model\Split\AbstractContractorSplit;

/**
 * BaseContractor
 *
 * @ORM\Table(name="contractor")
 * @ORM\Entity(repositoryClass="Evrinoma\ContractorBundle\Repository\ContractorRepository")
 */
final class BaseContractorSplit extends AbstractContractorSplit
{
}