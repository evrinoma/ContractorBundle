<?php

namespace Evrinoma\ContractorBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * Class AbstractBaseContractor
 *
 * @ORM\MappedSuperclass
 */
abstract class AbstractContractor implements ContractorInterface
{
    use IdTrait, ActiveTrait, CreateUpdateAtTrait;

//region SECTION: Fields
    /**
     * @var string
     *
     * @ORM\Column(name="short_name", type="string", length=255, nullable=false)
     */
    protected string $shortName;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=255, nullable=true)
     */
    protected string $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="inn", type="string", length=255, nullable=true)
     */
    protected string $inn;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @return string
     */
    public function getInn(): string
    {
        return $this->inn;
    }

    /**
     * @param string $shortName
     *
     * @return $this
     */
    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * @param string $fullName
     *
     * @return $this
     */
    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @param string $inn
     *
     * @return $this
     */
    public function setInn(string $inn): self
    {
        $this->inn = $inn;

        return $this;
    }
//endregion Getters/Setters
}
