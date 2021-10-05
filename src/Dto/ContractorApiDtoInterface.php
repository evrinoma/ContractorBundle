<?php


namespace Evrinoma\ContractorBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\DependencyInterface;
use Evrinoma\DtoCommon\ValueObject\IdentityInterface;
use Evrinoma\DtoCommon\ValueObject\IdInterface;
use Evrinoma\DtoCommon\ValueObject\NameInterface;

interface ContractorApiDtoInterface extends DtoInterface, IdInterface,IdentityInterface,DependencyInterface,NameInterface, ActiveInterface
{
}