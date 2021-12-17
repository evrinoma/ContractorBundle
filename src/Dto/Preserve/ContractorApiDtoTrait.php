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
        parent::setActive($id);
    }

    /**
     * @param string $identity
     */
    public function setIdentity(string $identity): void
    {
        parent::setActive($identity);
    }

    /**
     * @param string $dependency
     */
    public function setDependency(string $dependency): void
    {
        parent::setActive($dependency);
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        parent::setActive($name);
    }
//endregion Getters/Setters
}