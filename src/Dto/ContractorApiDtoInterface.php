<?php


namespace Evrinoma\ContractorBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface ContractorApiDtoInterface extends DtoInterface
{
//region SECTION: Public
    /**
     * @return bool
     */
    public function hasEntityId(): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getEntityId(): string;

    /**
     * @return string
     */
    public function getInn(): string;

    /**
     * @return string
     */
    public function getFullName(): string;

    /**
     * @return string
     */
    public function getShortname(): string;

    /**
     * @return string
     */
    public function getActive(): string;
//endregion Getters/Setters
}