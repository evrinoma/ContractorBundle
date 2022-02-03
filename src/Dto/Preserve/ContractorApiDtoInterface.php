<?php


namespace Evrinoma\ContractorBundle\Dto\Preserve;


use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\DependencyInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdentityInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\NameInterface;

interface ContractorApiDtoInterface extends IdInterface, IdentityInterface, DependencyInterface, NameInterface, ActiveInterface
{
}