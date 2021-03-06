<?php

namespace Evrinoma\ContractorBundle\Manager;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Exception\ContractorNotFoundException;
use Evrinoma\ContractorBundle\Exception\ContractorProxyException;
use Evrinoma\ContractorBundle\Model\Basic\ContractorInterface;

interface QueryManagerInterface
{
//region SECTION: Getters/Setters
    /**
     * @param ContractorApiDtoInterface $dto
     *
     * @return ContractorInterface
     */
    public function get(ContractorApiDtoInterface $dto): ContractorInterface;

    /**
     * @param ContractorApiDtoInterface $dto
     *
     * @return ContractorInterface[]
     * @throws ContractorNotFoundException
     */
    public function criteria(ContractorApiDtoInterface $dto): array;

    /**
     * @param ContractorApiDtoInterface $dto
     *
     * @return ContractorInterface
     * @throws ContractorProxyException
     */
    public function proxy(ContractorApiDtoInterface $dto): ContractorInterface;
//endregion Getters/Setters
}