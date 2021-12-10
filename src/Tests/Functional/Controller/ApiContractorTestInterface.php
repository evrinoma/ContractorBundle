<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Controller;

interface ApiContractorTestInterface
{
    public function testPostIdentity(): void;

    public function testPostIdentityDependency(): void;

    public function testPostIdentityDependencyIsolate(): void;
}