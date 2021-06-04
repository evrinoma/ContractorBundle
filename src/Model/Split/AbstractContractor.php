<?php

namespace Evrinoma\ContractorBundle\Model\Split;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractContractor implements ContractorSplitInterface
{
    use IdTrait, ActiveTrait, CreateUpdateAtTrait;

//region SECTION: Fields
    /**
     * @ORM\OneToOne(targetEntity="Evrinoma\ContractorBundle\Model\ContractorPersonInterface")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    protected ContractorPersonInterface $person;

    /**
     * @ORM\OneToOne(targetEntity="Evrinoma\ContractorBundle\Model\ContractorCompanyInterface")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected ContractorCompanyInterface $company;
//endregion Fields

//region SECTION: Getters/Setters

    /**
     * @return ContractorPersonInterface
     */
    public function getPerson(): ContractorPersonInterface
    {
        return $this->person;
    }

    /**
     * @return ContractorCompanyInterface
     */
    public function getCompany(): ContractorCompanyInterface
    {
        return $this->company;
    }

    /**
     * @param ContractorPersonInterface $person
     *
     * @return self
     */
    public function setPerson(ContractorPersonInterface $person): self
    {
        $this->person = $person;

        return $this;
    }

    /**
     * @param ContractorCompanyInterface $company
     *
     * @return self
     */
    public function setCompany(ContractorCompanyInterface $company): self
    {
        $this->company = $company;

        return $this;
    }
//endregion Getters/Setters
}
