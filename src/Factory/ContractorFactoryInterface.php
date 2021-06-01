<?php


namespace Evrinoma\ContractorBundle\Factory;


use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Model\ContractorInterface;

interface ContractorFactoryInterface
{
//region SECTION: Public
    /**
     * @param ContractorApiDtoInterface $dto
     *
     * @return ContractorInterface
     */
    public function create(ContractorApiDtoInterface $dto): ContractorInterface;
//endregion Public
}