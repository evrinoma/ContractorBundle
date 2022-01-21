<?php


namespace Evrinoma\ContractorBundle\Model\Basic;

use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;
use Evrinoma\UtilsBundle\Entity\NameInterface;

interface ContractorInterface extends ActiveInterface, CreateUpdateAtInterface, IdInterface, NameInterface
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
     * @param string $isolate
     *
     * @return AbstractContractor
     */
    public function setIsolate(string $isolate): self;

    /**
     * @param string $dependency
     *
     * @return AbstractContractor
     */
    public function setDependency(string $dependency): self;

    /**
     * @param string $identity
     *
     * @return AbstractContractor
     */
    public function setIdentity(string $identity): self;
}