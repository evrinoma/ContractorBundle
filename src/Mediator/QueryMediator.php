<?php


namespace Evrinoma\ContractorBundle\Mediator;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;
use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;


class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
//region SECTION: Fields
    protected static string $alias = 'contractor';
//endregion Fields

//region SECTION: Public
    public function createQuery(DtoInterface $dto, QueryBuilder $builder): void
    {
        $alias = $this->alias();

        /** @var $dto ContractorApiDtoInterface */
        if ($dto->hasActive()) {
            $builder
                ->andWhere($alias.'.active = :active')
                ->setParameter('active', $dto->getActive());
        }
        if ($dto->hasIdentity()) {
            $builder->andWhere($alias.'.identity like :identity')
                ->setParameter('identity', '%'.$dto->getIdentity().'%');
        }
        if ($dto->hasDependency()) {
            $builder->andWhere($alias.'.dependency like :dependency')
                ->setParameter('dependency', '%'.$dto->getDependency().'%');
        }
        if ($dto->hasName()) {
            $builder->andWhere($alias.'.name = :name')
                ->setParameter('name', '%'.$dto->getName().'%');
        }
    }
//endregion Public
}