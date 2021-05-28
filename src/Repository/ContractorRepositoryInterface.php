<?php


namespace Evrinoma\ContractorBundle\Repository;


use Evrinoma\ContractorBundle\Exception\ContractorCannotBeRemovedException;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeSavedException;
use Evrinoma\ContractorBundle\Exception\ContractorNotFoundException;
use Evrinoma\ContractorBundle\Model\ContractorInterface;

interface ContractorRepositoryInterface
{
//region SECTION: Public
    /**
     * @param ContractorInterface $contractor
     *
     * @return bool
     * @throws ContractorCannotBeSavedException
     */
    public function save(ContractorInterface $contractor): bool;

    /**
     * @param ContractorInterface $contractor
     *
     * @return bool
     * @throws ContractorCannotBeRemovedException
     */
    public function remove(ContractorInterface $contractor): bool;
//endregion Public

//region SECTION: Find Filters Repository
    /**
     * @param ContractorInterface $dto
     *
     * @return array
     * @throws ContractorNotFoundException
     */
    public function findByCriteria(ContractorInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return ContractorInterface
     * @throws ContractorNotFoundException
     */
    public function find(string $id, $lockMode = NULL, $lockVersion = NULL);
//endregion Find Filters Repository
}