<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Action;

interface BaseContractorTestInterface
{
    public function actionPostIdentity(): void;

    public function actionPostIdentityDependency(): void;

    public function actionPostIdentityDependencyIsolate(): void;
}