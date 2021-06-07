<?php

namespace Evrinoma\ContractorBundle\Model\Split;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * @ORM\MappedSuperclass
 * @ORM\Table(indexes={@ORM\Index(name="idx_contractor", columns={"identity"})})
 */
abstract class AbstractContractorPerson implements ContractorPersonInterface
{
    use IdTrait;

//region SECTION: Fields
    /**
     * @var string
     *
     * @ORM\Column(name="identity", type="string", length=255, nullable=true)
     */
    protected string $identity;
    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    protected string $lastName;
    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    protected string $firstName;
    /**
     * @var string
     *
     * @ORM\Column(name="middle_name", type="string", length=255, nullable=false)
     */
    protected string $middleName;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getIdentity(): string
    {
        return $this->identity;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    /**
     * @param string $identity
     *
     * @return AbstractContractorPerson
     */
    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * @param string $lastName
     *
     * @return AbstractContractorPerson
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @param string $firstName
     *
     * @return AbstractContractorPerson
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @param string $middleName
     *
     * @return AbstractContractorPerson
     */
    public function setMiddleName(string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }
//endregion Getters/Setters


}
