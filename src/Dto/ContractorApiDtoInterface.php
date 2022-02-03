<?php


namespace Evrinoma\ContractorBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\DependencyInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdentityInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\NameInterface;

interface ContractorApiDtoInterface extends DtoInterface, IdInterface, IdentityInterface, DependencyInterface, NameInterface, ActiveInterface
{
}