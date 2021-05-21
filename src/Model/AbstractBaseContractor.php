<?php

namespace Evrinoma\ContrAgentBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * Class AbstractBaseContractor
 *
 * @package Evrinoma\ContrAgentBundle\Model
 * @ORM\MappedSuperclass
 */
abstract class AbstractBaseContractor implements ActiveInterface
{
    use IdTrait, ActiveTrait, CreateUpdateAtTrait;

//region SECTION: Fields
    /**
     * @var string
     *
     * @ORM\Column(name="short_name", type="string", length=255, nullable=false)
     */
    private string $shortName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="full_name", type="string", length=255, nullable=true)
     */
    private string $fullName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="inn", type="string", length=255, nullable=true)
     */
    private string $inn;
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
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * @return string|null
     */
    public function getInn(): ?string
    {
        return $this->inn;
    }
//endregion Getters/Setters
}
