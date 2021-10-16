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
     */
    protected function setActive(string $active): void
    {
        $this->active = $active;
    }

    /**
     * @param int|null $id
     */
    protected function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $identity
     */
    protected function setIdentity(string $identity): void
    {
        $this->identity = $identity;
    }

    /**
     * @param string $dependency
     */
    protected function setDependency(string $dependency): void
    {
        $this->dependency = $dependency;
    }

    /**
     * @param string $name
     */
    protected function setName(string $name): void
    {
        $this->name = $name;
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