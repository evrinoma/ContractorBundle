<?php

namespace Evrinoma\ContractorBundle\Mediator;


use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Model\ContractorInterface;

interface CommandMediatorInterface
{
    public function onUpdate(ContractorApiDtoInterface $dto, ContractorInterface $entity):ContractorInterface;

    public function onDelete(ContractorApiDtoInterface $dto, ContractorInterface $entity):void;

    public function onCreate(ContractorApiDtoInterface $dto, ContractorInterface $entity):ContractorInterface;
}