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
    public function hasShortName(): bool;

    /**
     * @return bool
     */
    public function hasFullName(): bool;

    /**
     * @return bool
     */
    public function hasInn(): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getId(): string;

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
    public function getShortName(): string;

    /**
     * @return string
     */
    public function getActive(): string;
//endregion Getters/Setters
}