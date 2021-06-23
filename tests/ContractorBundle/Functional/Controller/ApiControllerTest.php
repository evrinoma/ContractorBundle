<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Controller;

/**
 * @group functional
 */
class ApiControllerTest extends AbstractControllerTest
{
//region SECTION: Public
    public function testGetAction(): void
    {
        $expected  = '{"id":"01623","city":"Lommatzsch"}';
        $expected2 = '{"id":"01623","city":"Lommatzsch"}';
        $crawler   = $this->client->request('GET', 'evrinoma/api/contractor?class=Evrinoma%5CContractorBundle%5CDto%5CContractorApiDto&id=3');

        $this->assertEquals($expected, $expected2);
    }

    public function testCriteriaAction(): void
    {
        $this->client->request('GET', '/api/contractor/criteria');
    }

    public function testDeleteAction(): void
    {
        $this->client->request('DELETE', '/api/contractor/delete');
    }

    public function testPutAction(): void
    {
        $this->client->request('PUT', '/api/contractor/save');
    }

    public function testPostAction(): void
    {
        $this->client->request('POST', '/api/contractor/create');
    }
//endregion Public

//region SECTION: Getters/Setters
    public function setUp(): void
    {
        parent::setUp();
        //   $this->loadContractorFixtures();
    }
//endregion Getters/Setters
}
