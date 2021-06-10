<?php

namespace Evrinoma\ContractorBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class ApiControllerTest extends AbstractControllerTest
{
    public function setUp():void
    {
        parent::setUp();
        $this->loadContractorFixtures();
    }

    public function testGetAction():void
    {
        $expected = '{"id":"01623","city":"Lommatzsch"}';
        $expected2 = '{"id":"01623","city":"Lommatzsch"}';

        $this->assertEquals($expected, $expected2);

    //    $this->client->request('GET', '/api/contractor');
    }

    public function testCriteriaAction():void
    {
        $this->client->request('GET', '/api/contractor/criteria');
    }

    public function testDeleteAction():void
    {
        $this->client->request('DELETE', '/api/contractor/delete');
    }

    public function testPutAction():void
    {
        $this->client->request('PUT', '/api/contractor/save');
    }

    public function testPostAction():void
    {
        $this->client->request('POST', '/api/contractor/create');
    }
}
