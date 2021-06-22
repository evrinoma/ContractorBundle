<?php

namespace Evrinoma\ContractorBundle\Entity\Basic;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ContractorBundle\Model\Basic\AbstractContractor;

/**
 * BaseContractor
 *
 * @ORM\Table(name="contractor")
 * @ORM\Entity(repositoryClass="Evrinoma\ContractorBundle\Repository\ContractorRepository")
 */
final class BaseContractor extends AbstractContractor
{
}