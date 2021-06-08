<?php


namespace Evrinoma\ContractorBundle\Model\Basic;

use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;

interface ContractorInterface extends ActiveInterface, CreateUpdateAtInterface, IdInterface
{
    /**
     * @return string
     */
    public function getIdentity(): string;

    /**
     * @return string
     */
    public function getDependency(): string;

    /**
     * @return string
     */
    public function getIsolate(): string;

    /**
     * @return string
     */
    public function getName(): string;
}