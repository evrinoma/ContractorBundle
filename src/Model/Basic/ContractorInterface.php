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
    public function getShortName(): string;

    /**
     * @return string
     */
    public function getFullName(): string;

    /**
     * @return string
     */
    public function getInn(): string;

    /**
     * @param string $shortName
     *
     * @return $this
     */
    public function setShortName(string $shortName): self;

    /**
     * @param string $fullName
     *
     * @return $this
     */
    public function setFullName(string $fullName): self;

    /**
     * @param string $inn
     *
     * @return $this
     */
    public function setInn(string $inn): self;
}