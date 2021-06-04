<?php


namespace Evrinoma\ContractorBundle\Model\Split;

use Evrinoma\UtilsBundle\Entity\IdInterface;

interface ContractorPersonInterface extends IdInterface
{
    /**
     * @return string
     */
    public function getIdentity(): string;

    /**
     * @return string
     */
    public function getLastName(): string;

    /**
     * @return string
     */
    public function getFirstName(): string;

    /**
     * @return string
     */
    public function getMiddleName(): string;

    /**
     * @param string $identity
     *
     * @return self
     */
    public function setIdentity(string $identity): self;

    /**
     * @param string $lastName
     *
     * @return self
     */
    public function setLastName(string $lastName): self;

    /**
     * @param string $firstName
     *
     * @return self
     */
    public function setFirstName(string $firstName): self;

    /**
     * @param string $middleName
     *
     * @return self
     */
    public function setMiddleName(string $middleName): self;
}