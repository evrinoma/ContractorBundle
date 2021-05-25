<?php

namespace Evrinoma\ContractorBundle\Manager;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Model\ContractorInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;

interface QueryManagerInterface extends RestInterface
{
//region SECTION: Getters/Setters
    /**
     * @param ContractorApiDtoInterface $dto
     *
     * @return ContractorInterface
     */
    public function get(ContractorApiDtoInterface $dto): ContractorInterface;
//endregion Getters/Setters
}