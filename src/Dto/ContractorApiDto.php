<?php

namespace Evrinoma\ContractorBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\DependencyTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdentityTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\NameTrait;
use Symfony\Component\HttpFoundation\Request;

class ContractorApiDto extends AbstractDto implements ContractorApiDtoInterface
{
//region SECTION: Fields
    use IdTrait, ActiveTrait, DependencyTrait, IdentityTrait, NameTrait;

//endregion Fields

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id         = $request->get(ContractorApiDtoInterface::ID);
            $identity   = $request->get(ContractorApiDtoInterface::IDENTITY);
            $dependency = $request->get(ContractorApiDtoInterface::DEPENDENCY);
            $name       = $request->get(ContractorApiDtoInterface::NAME);
            $active     = $request->get(ContractorApiDtoInterface::ACTIVE);

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