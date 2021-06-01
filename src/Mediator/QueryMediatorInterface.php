<?php


namespace Evrinoma\ContractorBundle\Mediator;


use Doctrine\ORM\QueryBuilder;
use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;

interface QueryMediatorInterface
{
//region SECTION: Public
    /**
     * @return string
     */
    public function alias(): string;

    /**
     * @param ContractorApiDtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return mixed
     */
    public function createQuery(ContractorApiDtoInterface $dto, QueryBuilder $builder):void;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param ContractorApiDtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return array
     */
    public function getResult(ContractorApiDtoInterface $dto, QueryBuilder $builder): array;

//endregion Getters/Setters
}