<?php

namespace Evrinoma\ContractorBundle\Mediator;

use Evinoma\UtilsBundle\Mediator\AbstractCommandMediator;
use Evrinoma\ContractorBundle\Model\Basic\ContractorInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
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
    public function onUpdate(DtoInterface $dto, $entity): ContractorInterface
    {
        $this->setIsolate($entity);

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
    }

    public function onCreate(DtoInterface $dto, $entity): ContractorInterface
    {
        $this->setIsolate($entity);

        return $entity;
    }
//endregion Public
}