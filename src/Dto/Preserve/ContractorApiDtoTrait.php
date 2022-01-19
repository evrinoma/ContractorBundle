<?php


namespace Evrinoma\ContractorBundle\Dto\Preserve;

trait ContractorApiDto
{
//region SECTION: Getters/Setters
    /**
     * @param string $active
     */
    public function setActive(string $active): void
    {
        parent::setActive($active);
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        parent::setId($id);
    }

    /**
     * @param string $identity
     */
    public function setIdentity(string $identity): void
    {
        parent::setIdentity($identity);
    }

    /**
     * @param string $dependency
     */
    public function setDependency(string $dependency): void
    {
        parent::setDependency($dependency);
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        parent::setName($name);
    }
//endregion Getters/Setters
}