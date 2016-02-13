<?php

namespace Tests\AppBundle\Controller;

class ProposalControllerTest extends BaseTestCase
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
}
