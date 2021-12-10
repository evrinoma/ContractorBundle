<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Controller;

use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestTrait as BaseApiControllerTestTrait;

trait ApiControllerTestTrait
{
    use BaseApiControllerTestTrait;

//region SECTION: Public
    public function testPostIdentity(): void
    {
        $this->actionService->actionPostIdentity();
    }

    public function testPostIdentityDependency(): void
    {
        $this->actionService->actionPostIdentityDependency();
    }

    public function testPostIdentityDependencyIsolate(): void
    {
        $this->actionService->actionPostIdentityDependencyIsolate();
    }
//endregion Public
}