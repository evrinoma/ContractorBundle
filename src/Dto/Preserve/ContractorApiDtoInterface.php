<?php


namespace Evrinoma\ContractorBundle\Dto\Preserve;


interface ContractorApiDtoInterface
{
//region SECTION: Getters/Setters
    /**
     * @param string $active
     */
    public function setActive(string $active): void;

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void;

    /**
     * @param string $identity
     */
    public function setIdentity(string $identity): void;

    /**
     * @param string $dependency
     */
    public function setDependency(string $dependency): void;

    /**
     * @param string $name
     */
    public function setName(string $name): void;
//endregion Getters/Setters
}