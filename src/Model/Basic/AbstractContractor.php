<?php

namespace Evrinoma\ContractorBundle\Model\Basic;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Evrinoma\UtilsBundle\Entity\NameTrait;

/**
 * Class AbstractBaseContractor
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_contractor", columns={"identity", "dependency", "isolate"})})
 */
abstract class AbstractContractor implements ContractorInterface
{
    use IdTrait, ActiveTrait, CreateUpdateAtTrait, NameTrait;

//region SECTION: Fields
    /**
     * @var string
     *
     * @ORM\Column(name="identity", type="string", length=255, nullable=false)
     */
    protected string $identity;
    /**
     * @var string
     *
     * @ORM\Column(name="dependency", type="string", length=255, nullable=false)
     */
    protected string $dependency;
    /**
     * @var string
     *
     * @ORM\Column(name="isolate", type="string", length=255, nullable=false)
     */
    protected string $isolate = '';
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
    public function getDependency(): string
    {
        return $this->dependency;
    }

    /**
     * @return string
     */
    public function getIsolate(): string
    {
        return $this->isolate;
    }

    /**
     * @param string $identity
     *
     * @return AbstractContractor
     */
    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * @param string $dependency
     *
     * @return AbstractContractor
     */
    public function setDependency(string $dependency): self
    {
        $this->dependency = $dependency;

        return $this;
    }

    /**
     * @param string $isolate
     *
     * @return AbstractContractor
     */
    public function setIsolate(string $isolate): self
    {
        $this->isolate = $isolate;

        return $this;
    }
//endregion Getters/Setters
}
