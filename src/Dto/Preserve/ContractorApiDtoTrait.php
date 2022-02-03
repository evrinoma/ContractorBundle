<?php


namespace Evrinoma\ContractorBundle\Dto\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait ContractorApiDto
{
//region SECTION: Getters/Setters
    /**
     * @param string $active
     *
     * @return DtoInterface
     */
    public function setActive(string $active): DtoInterface
    {
        return parent::setActive($active);
    }

    /**
     * @param int|null $id
     *
     * @return DtoInterface
     */
    public function setId(?int $id): DtoInterface
    {
        return parent::setId($id);
    }

    /**
     * @param string $identity
     *
     * @return DtoInterface
     */
    public function setIdentity(string $identity): DtoInterface
    {
        return parent::setIdentity($identity);
    }

    /**
     * @param string $dependency
     *
     * @return DtoInterface
     */
    public function setDependency(string $dependency): DtoInterface
    {
        return parent::setDependency($dependency);
    }

    /**
     * @param string $name
     *
     * @return DtoInterface
     */
    public function setName(string $name): DtoInterface
    {
        return parent::setName($name);
    }
//endregion Getters/Setters
}