<?php

namespace Evrinoma\ContractorBundle\Manager;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;

interface CommandManagerInterface
{
//region SECTION: Public
    public function post(ContractorApiDtoInterface $dto): void;

    public function put(ContractorApiDtoInterface $dto): void;

    public function delete(ContractorApiDtoInterface $dto): void;
//endregion Public
}

