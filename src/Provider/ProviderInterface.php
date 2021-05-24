<?php


namespace Evrinoma\ContractorBundle\Provider;


use Evrinoma\DtoBundle\Dto\DtoInterface;

interface ProviderInterface
{
//region SECTION: Public
    public function create(DtoInterface $dto);

    public function read(DtoInterface $dto);

    public function update(DtoInterface $dto);

    public function delete(DtoInterface $dto);
//endregion Public
}