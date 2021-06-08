<?php

namespace Evrinoma\ContractorBundle\Mediator;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Model\Basic\ContractorInterface;
use Symfony\Component\Uid\Uuid;


class CommandMediator implements CommandMediatorInterface
{
//region SECTION: Protected
    protected function setIsolate(ContractorInterface $entity)
    {
        if (!$entity->getIdentity() && !$entity->getDependency()) {
            $namespace = Uuid::v4();
            $uuid      = Uuid::v3($namespace, $entity->getName());
            $entity->setIsolate($uuid->toRfc4122());
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