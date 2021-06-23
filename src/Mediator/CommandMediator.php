<?php

namespace Evrinoma\ContractorBundle\Mediator;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Model\Basic\ContractorInterface;

class CommandMediator implements CommandMediatorInterface
{
//region SECTION: Protected
    protected function setIsolate(ContractorInterface $entity)
    {
        if (!$entity->getIdentity() && !$entity->getDependency()) {
            $isolate = md5($entity->getName());
            $entity->setIsolate($isolate);
            $entity->setIdentity($isolate);
            $entity->setDependency($isolate);
        }
    }
//endregion Protected

//region SECTION: Public
    public function onUpdate(ContractorApiDtoInterface $dto, ContractorInterface $entity): ContractorInterface
    {
        $this->setIsolate($entity);

        return $entity;
    }

    public function onDelete(ContractorApiDtoInterface $dto, ContractorInterface $entity): void
    {
    }

    public function onCreate(ContractorApiDtoInterface $dto, ContractorInterface $entity): ContractorInterface
    {
        $this->setIsolate($entity);

        return $entity;
    }
//endregion Public
}