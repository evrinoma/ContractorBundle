<?php


namespace Evrinoma\ContractorBundle\Dto\Preserve;

trait ContractorApiDto
{
//region SECTION: Getters/Setters
    /**
     * @param string $active
     *
     * @return self
     */
    public function setActive(string $active): self
    {
        return parent::setActive($active);
    }

    /**
     * @param int|null $id
     *
     * @return self
     */
    public function setId(?int $id): self
    {
        return parent::setId($id);
    }

    /**
     * @param string $identity
     *
     * @return self
     */
    public function setIdentity(string $identity): self
    {
        return parent::setIdentity($identity);
    }

    /**
     * @param string $dependency
     *
     * @return self
     */
    public function setDependency(string $dependency): self
    {
        return parent::setDependency($dependency);
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        return parent::setName($name);
    }
//endregion Getters/Setters
}