<?php

namespace Evrinoma\ContractorBundle\Mediator;


use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeRemovedException;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeSavedException;
use Evrinoma\ContractorBundle\Model\Basic\ContractorInterface;


interface CommandMediatorInterface
{
//region SECTION: Public
    /**
     * @param ContractorApiDtoInterface $dto
     * @param ContractorInterface       $entity
     *
     * @return ContractorInterface
     * @throws ContractorCannotBeSavedException
     */
    public function onUpdate(ContractorApiDtoInterface $dto, ContractorInterface $entity): ContractorInterface;

    /**
     * @param ContractorApiDtoInterface $dto
     * @param ContractorInterface       $entity
     *
     * @throws ContractorCannotBeRemovedException
     */
    public function onDelete(ContractorApiDtoInterface $dto, ContractorInterface $entity): void;

    /**
     * @param ContractorApiDtoInterface $dto
     * @param ContractorInterface       $entity
     *
     * @return ContractorInterface
     * @throws ContractorCannotBeSavedException
     */
    public function onCreate(ContractorApiDtoInterface $dto, ContractorInterface $entity): ContractorInterface;
//endregion Public
}