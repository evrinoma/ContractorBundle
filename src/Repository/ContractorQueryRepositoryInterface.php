<?php


namespace Evrinoma\ContractorBundle\Repository;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Exception\ContractorNotFoundException;
use Evrinoma\ContractorBundle\Exception\ContractorProxyException;
use Evrinoma\ContractorBundle\Model\Basic\ContractorInterface;


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
    public function find(string $id, $lockMode = null, $lockVersion = null): ContractorInterface;

    /**
     * @param string $id
     *
     * @return ContractorInterface
     * @throws ContractorProxyException
     */
    public function proxy(string $id): ContractorInterface;
//endregion Find Filters Repository
}