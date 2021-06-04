<?php

namespace Evrinoma\ContractorBundle\Manager;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Model\Basic\ContractorInterface;

interface CommandManagerInterface
{
//region SECTION: Public
    public function post(ContractorApiDtoInterface $dto): ContractorInterface;

    public function put(ContractorApiDtoInterface $dto): ContractorInterface;

    public function delete(ContractorApiDtoInterface $dto): void;
//endregion Public
}

