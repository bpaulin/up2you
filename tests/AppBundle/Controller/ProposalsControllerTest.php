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
            array("id", "name", "_links"),
            array_keys($data['_embedded']['items'][0])
        );
    }

    /**
     * @group wip
     */
    public function testProposerCanPropose()
    {
        $this->loadFixtureFiles(array(
            '@AppBundle/DataFixtures/ORM/test.yml'
        ));
        $client = $this->createClientAuthenticatedAs('proposer');

        $client->request(
            'POST',
            '/api/proposal',
            array(),
            array(),
            array('CONTENT_TYPE'=>'application/json'),
            json_encode(array('proposal'=>array('name'=>'eeeeeeeeeeeeeee')))
        );

        $this->isSuccessful($client->getResponse());
        $location = $client->getResponse()->headers->get('Location');

        $client->request(
            'GET',
            $location
        );

        $this->isSuccessful($client->getResponse());

        $this->assertJson($client->getResponse()->getContent());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(
            array("id", "name", "_links"),
            array_keys($data)
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
            array("id", "name", "_links"),
            array_keys($data['_embedded']['items'][0])
        );
    }
}
