<?php


namespace Evrinoma\ContractorBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface ContractorApiDtoInterface extends DtoInterface
{
//region SECTION: Public
    /**
     * @return bool
     */
    public function hasId(): bool;

    /**
     * @return bool
     */
    public function hasIdentity(): bool;

    /**
     * @return bool
     */
    public function hasName(): bool;

    /**
     * @return bool
     */
    public function hasDependency(): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getIdentity(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDependency(): string;

    /**
     * @return string
     */
    public function getActive(): string;
//endregion Getters/Setters
}