<?php


namespace Evrinoma\ContractorBundle\Model\Split;

use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;

interface ContractorInterface extends ActiveInterface, CreateUpdateAtInterface, IdInterface
{
//region SECTION: Getters/Setters
    /**
     * @return ContractorPersonInterface
     */
    public function getPerson(): ContractorPersonInterface;

    /**
     * @return ContractorCompanyInterface
     */
    public function getCompany(): ContractorCompanyInterface;

    /**
     * @param ContractorPersonInterface $person
     *
     * @return $this
     */
    public function setPerson(ContractorPersonInterface $person): self;

    /**
     * @param ContractorCompanyInterface $person
     *
     * @return $this
     */
    public function setCompany(ContractorCompanyInterface $person): self;
//endregion Getters/Setters
}