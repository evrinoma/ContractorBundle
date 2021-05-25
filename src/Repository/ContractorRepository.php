<?php

namespace Evrinoma\ContractorBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeRemovedException;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeSavedException;
use Evrinoma\ContractorBundle\Exception\ContractorNotFoundException;
use Evrinoma\ContractorBundle\Model\ContractorInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;

class ContractorRepository extends ServiceEntityRepository implements ContractorRepositoryInterface
{
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

        try {
            $this->getEntityManager()->flush();
        } catch (OptimisticLockException $e) {
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

        try {
            $this->getEntityManager()->flush();
        } catch (OptimisticLockException $e) {
            throw new ContractorCannotBeSavedException($e->getMessage());
        }

        return true;
    }
//endregion Public

//region SECTION: Find Filters Repository
    /**
     * @param string $id
     *
     * @return ContractorInterface
     * @throws ContractorNotFoundException
     */
    public function find($id): ContractorInterface
    {
        /** @var ContractorInterface $contractor */
        $contractor = parent::find($id);

        if ($contractor === null) {
            throw new ContractorNotFoundException("Cannot find contractor with id $id");
        }

        return $contractor;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return parent::findAll();
    }

    /**
     * @param DtoInterface $dto
     *
     * @return array
     * @throws ContractorNotFoundException
     */
    public function findByCriteria(DtoInterface $dto): array
    {

    }
//endregion Find Filters Repository
}