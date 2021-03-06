<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Controller;

use Evrinoma\TestUtilsBundle\Action\ActionTestInterface;
use Evrinoma\TestUtilsBundle\Functional\AbstractFunctionalTest;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @group functional
 */
final class ApiControllerTest extends AbstractFunctionalTest implements ApiContractorTestInterface
{
    use ApiControllerTestTrait;
//region SECTION: Fields
    protected string $actionServiceName = 'evrinoma.contractor.test.functional.action.contractor';
//endregion Fields

//region SECTION: Protected
    protected function getActionService(ContainerInterface $container): ActionTestInterface
    {
        return $container->get($this->actionServiceName);
    }
//endregion Protected

//region SECTION: Getters/Setters
    public static function getFixtures(): array
    {
        return [];
    }
//endregion Getters/Setters
}
