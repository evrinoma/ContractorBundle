<?php


namespace Evrinoma\ContractorBundle\Model\Split;

use Evrinoma\UtilsBundle\Entity\IdInterface;

interface ContractorCompanyInterface extends IdInterface
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
    public function getIdentity(): string;

    /**
     * @return string
     */
    public function getDependency(): string;

    /**
     * @param string $shortName
     *
     * @return self
     */
    public function setShortName(string $shortName): self;

    /**
     * @param string $fullName
     *
     * @return self
     */
    public function setFullName(string $fullName): self;

    /**
     * @param string $identity
     *
     * @return self
     */
    public function setIdentity(string $identity): self;

    /**
     * @param string $dependency
     *
     * @return self
     */
    public function setDependency(string $dependency): self;
}