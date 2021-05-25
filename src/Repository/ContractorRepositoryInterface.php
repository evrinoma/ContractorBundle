<?php


namespace Evrinoma\ContractorBundle\Repository;


use Evrinoma\ContractorBundle\Exception\ContractorCannotBeRemovedException;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeSavedException;
use Evrinoma\ContractorBundle\Exception\ContractorNotFoundException;
use Evrinoma\ContractorBundle\Model\ContractorInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;

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
     * @return array
     */
    public function findAll(): array;

    /**
     * @param DtoInterface $dto
     *
     * @return array
     * @throws ContractorNotFoundException
     */
    public function findByCriteria(DtoInterface $dto): array;

    /**
     * @param string $id
     *
     * @return ContractorInterface
     * @throws ContractorNotFoundException
     */
    public function find(string $id): ContractorInterface;
//endregion Find Filters Repository
}