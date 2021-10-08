<?php

namespace Evrinoma\ContractorBundle\Dto;

use Evrinoma\ContractorBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\DependencyTrait;
use Evrinoma\DtoCommon\ValueObject\IdentityTrait;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Evrinoma\DtoCommon\ValueObject\NameTrait;
use Symfony\Component\HttpFoundation\Request;

class ContractorApiDto extends AbstractDto implements ContractorApiDtoInterface
{
//region SECTION: Fields
    use IdTrait, ActiveTrait, DependencyTrait, IdentityTrait, NameTrait;
//endregion Fields

//region SECTION: Protected
    /**
     * @param string $active
     *
     * @return ContractorApiDto
     */
    protected function setActive(string $active): ContractorApiDto
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @param int|null $id
     *
     * @return ContractorApiDto
     */
    protected function setId(?int $id): ContractorApiDto
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $identity
     *
     * @return ContractorApiDto
     */
    protected function setIdentity(string $identity): ContractorApiDto
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * @param string $dependency
     *
     * @return ContractorApiDto
     */
    protected function setDependency(string $dependency): ContractorApiDto
    {
        $this->dependency = $dependency;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return ContractorApiDto
     */
    protected function setName(string $name): ContractorApiDto
    {
        $this->name = $name;

        return $this;
    }
//endregion Protected

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id         = $request->get(ModelInterface::ID);
            $identity   = $request->get(ModelInterface::IDENTITY);
            $dependency = $request->get(ModelInterface::DEPENDENCY);
            $name       = $request->get(ModelInterface::NAME);
            $active     = $request->get(ModelInterface::ACTIVE);

            if ($active) {
                $this->setActive($active);
            }

            if ($dependency) {
                $this->setDependency($dependency);
            }

            if ($name) {
                $this->setName($name);
            }

            if ($identity) {
                $this->setIdentity($identity);
            }

            if ($id) {
                $this->setId($id);
            }
        }

        return $this;
    }
//endregion SECTION: Dto
}