<?php

namespace Evrinoma\ContractorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ContrAgentBundle\Model\AbstractBaseContractor;

/**
 * BaseContractor
 *
 * @ORM\Table(name="contragent")
 * @ORM\Entity
 */
class BaseContractor extends AbstractBaseContractor
{
}