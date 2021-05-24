<?php

namespace Evrinoma\ContractorBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

class ContractorApiDto extends AbstractDto implements ContractorApiDtoInterface
{
//region SECTION: Public
    public function hasContractor(): bool
    {
        return false;
    }
//endregion Public

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        return $this;
    }
//endregion SECTION: Dto
}