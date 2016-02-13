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

    public function testAnonymousCantPing()
    {
        $this->loadFixtureFiles(array(
            '@AppBundle/DataFixtures/ORM/test.yml'
        ));
        $client = static::createClient();

        $client->request('GET', '/api/ping');

        $this->isSuccessful($client->getResponse(), false);
    }
}
