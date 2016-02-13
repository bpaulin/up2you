<?php

namespace Tests\AppBundle\Controller;

class ApiControllerTest extends BaseTestCase
{
    public function testProposerCanPing()
    {
        $this->loadFixtureFiles(array(
            '@AppBundle/DataFixtures/ORM/test.yml'
        ));
        $client = $this->createClientAuthenticatedAs('voter1');

        $client->request('GET', '/api/ping');

        $this->isSuccessful($client->getResponse());
    }

    public function anonymousCantAccessProvider()
    {
        return array(
            array('GET', '/api/ping'),
            array('GET', '/api/proposals'),
            array('GET', '/api/votes'),
        );
    }

    /**
     * @dataProvider anonymousCantAccessProvider
     */
    public function testAnonymousCantAccess($method, $path)
    {
        $client = static::createClient();

        $client->request($method, $path);

        $this->assertStatusCode(
            401,
            $client
        );
    }

    public function proposerCantAccessProvider()
    {
        return array(
            array('GET', '/api/votes'),
            array('GET', '/api/proposals/todo'),
        );
    }

    /**
     * @dataProvider proposerCantAccessProvider
     */
    public function testProposerCantAccess($method, $path)
    {
        $client = $this->createClientAuthenticatedAs('proposer');

        $client->request($method, $path);

        $this->assertStatusCode(
            403,
            $client
        );
    }
}
