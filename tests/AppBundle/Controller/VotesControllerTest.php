<?php

namespace Tests\AppBundle\Controller;

class VotesControllerTest extends BaseTestCase
{
    public function testVotersCanViewVotes()
    {
        $this->loadFixtureFiles(array(
            '@AppBundle/DataFixtures/ORM/test.yml'
        ));
        $client = $this->createClientAuthenticatedAs('voter1');

        $client->request('GET', '/api/votes');

        $this->isSuccessful($client->getResponse());
        $this->assertJson($client->getResponse()->getContent());

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(
            array("id", "vote", "proposal"),
            array_keys($data[0])
        );
        $this->assertEquals(
            array("id", "name"),
            array_keys($data[0]["proposal"])
        );
    }
}
