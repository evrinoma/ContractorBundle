<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class ApiControllerTest extends AbstractControllerTest
{
    public function setUp()
    {
        parent::setUp();
        $this->loadContractorFixtures();
    }

    public function testGetAction():void
    {
        $this->client->request('GET', '/api/contractor');
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
