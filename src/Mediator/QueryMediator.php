<?php


namespace Evrinoma\ContractorBundle\Mediator;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;

class QueryMediator implements QueryMediatorInterface
{
//region SECTION: Fields
    protected static string $alias = 'contractor';
//endregion Fields

//region SECTION: Public
    public function createQuery(ContractorApiDtoInterface $dto, QueryBuilder $builder):void
    {
        $builder
            ->andWhere('contractor.active = :active')
            ->setParameter('active', $dto->getActive());
    }

    public function alias(): string
    {
        return self::$alias;
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getResult(ContractorApiDtoInterface $dto, QueryBuilder $builder): array
    {
        return $builder->getQuery()->getResult();
    }
//endregion Getters/Setters
}