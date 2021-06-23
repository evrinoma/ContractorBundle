<?php

namespace Evrinoma\ContractorBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * TestCase.
 */
abstract class CaseTest extends WebTestCase
{
//region SECTION: Fields
    protected $client;
//endregion Fields

//region SECTION: Protected
    /**
     * {@inheritdoc}
     */
    protected static function createKernel(array $options = [])
    {
        require_once __DIR__.'/app/Kernel.php';

        return new Kernel('test', true);
    }

    protected function createAuthenticatedClient($token = null)
    {

        if (null === $this->client) {
            $this->client = static::createClient();
        }


        return $this->client;
    }
//endregion Protected


}
