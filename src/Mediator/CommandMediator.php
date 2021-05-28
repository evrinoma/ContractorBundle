<?php

namespace Evrinoma\ContractorBundle\Mediator;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Model\ContractorInterface;


class CommandMediator implements CommandMediatorInterface
{
    public function onUpdate(ContractorApiDtoInterface $dto, ContractorInterface $entity):ContractorInterface
    {
        return $entity;
    }

    public function onDelete(ContractorApiDtoInterface $dto, ContractorInterface $entity):void
    {
    }

    public function onCreate(ContractorApiDtoInterface $dto, ContractorInterface $entity):ContractorInterface
    {
        return $entity;
    }
}