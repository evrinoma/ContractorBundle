<?php


namespace Evrinoma\ContractorBundle\Repository;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Exception\ContractorNotFoundException;


interface ContractorQueryRepositoryInterface
{
//region SECTION: Find Filters Repository
    /**
     * @param ContractorApiDtoInterface $dto
     *
     * @return array
     * @throws ContractorNotFoundException
     */
    public function findByCriteria(ContractorApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return
     * @throws ContractorNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null);
//endregion Find Filters Repository
}