<?php

namespace Tests\AppBundle\Controller;

class ProposalsControllerTest extends BaseTestCase
{
    public function testProposerCanViewProposals()
    {
        $this->loadFixtureFiles(array(
            '@AppBundle/DataFixtures/ORM/test.yml'
        ));
        $client = $this->createClientAuthenticatedAs('proposer');

        $client->request('GET', '/api/proposals');

        $this->isSuccessful($client->getResponse());
        $this->assertJson($client->getResponse()->getContent());

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(
            array("id", "name"),
            array_keys($data[0])
        );
    }

    public function testVoterCanViewProposalsToDo()
    {
        $this->loadFixtureFiles(array(
            '@AppBundle/DataFixtures/ORM/test.yml'
        ));
        $client = $this->createClientAuthenticatedAs('voter1');

        $client->request('GET', '/api/proposals/todo');

        $this->isSuccessful($client->getResponse());
        $this->assertJson($client->getResponse()->getContent());

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(
            array("id", "name"),
            array_keys($data[0])
        );
    }
}
