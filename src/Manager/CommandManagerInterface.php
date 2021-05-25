<?php

namespace Evrinoma\ContractorBundle\Manager;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;

interface CommandManagerInterface extends RestInterface
{
//region SECTION: Public
    public function post(ContractorApiDtoInterface $dto): void;

    public function put(ContractorApiDtoInterface $dto): void;

    public function delete(ContractorApiDtoInterface $dto): void;
//endregion Public
}

