<?php

namespace Evrinoma\ContractorBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeRemovedException;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeSavedException;
use Evrinoma\ContractorBundle\Exception\ContractorNotFoundException;
use Evrinoma\ContractorBundle\Mediator\QueryMediatorInterface;
use Evrinoma\ContractorBundle\Model\Basic\ContractorInterface;

class ContractorRepository extends ServiceEntityRepository implements ContractorRepositoryInterface
{
//region SECTION: Fields
    private QueryMediatorInterface $mediator;
//endregion Fields

//region SECTION: Constructor
    /**
     * ContractorRepository constructor.
     *
     * @param ManagerRegistry        $registry
     * @param string                 $entityClass
     * @param QueryMediatorInterface $mediator
     */
    public function __construct(ManagerRegistry $registry, string $entityClass, QueryMediatorInterface $mediator)
    {
        parent::__construct($registry, $entityClass);
        $this->mediator = $mediator;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param ContractorInterface $contractor
     *
     * @return bool
     * @throws ContractorCannotBeSavedException
     */
    public function save(ContractorInterface $contractor): bool
    {
        try {
            $this->getEntityManager()->persist($contractor);
        } catch (ORMInvalidArgumentException $e) {
            throw new ContractorCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param ContractorInterface $contractor
     *
     * @return bool
     * @throws ContractorCannotBeRemovedException
     */
    public function remove(ContractorInterface $contractor): bool
    {
        $contractor->setActiveToDelete();

        return true;
    }
//endregion Public

//region SECTION: Find Filters Repository
    /**
     * @param mixed|string $id
     *
     * @return ContractorInterface
     * @throws ContractorNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): ContractorInterface
    {
        /** @var ContractorInterface $contractor */
        $contractor = parent::find($id);

        if ($contractor === null) {
            throw new ContractorNotFoundException("Cannot find contractor with id $id");
        }

        return $contractor;
    }

    /**
     * @param ContractorApiDtoInterface $dto
     *
     * @return array
     * @throws ContractorNotFoundException
     */
    public function findByCriteria(ContractorApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $contractors = $this->mediator->getResult($dto, $builder);

        if (count($contractors) === 0) {
            throw new ContractorNotFoundException("Cannot find contractor by findByCriteria");
        }

        return $contractors;
    }
//endregion Find Filters Repository
}