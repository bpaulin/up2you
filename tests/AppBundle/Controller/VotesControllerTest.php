<?php

namespace Tests\AppBundle\Controller;

class VotesControllerTest extends BaseTestCase
{
    public function testVotersCanViewAllVotes()
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
            array_keys($data['_embedded']['items'][0])
        );
        $this->assertEquals(
            array("id", "name", "_links"),
            array_keys($data['_embedded']['items'][0]["proposal"])
        );
    }

    public function votersCanViewVotesProvider()
    {
        return array(
            array('/api/votes?vote=maybe', 'maybe'),
            array('/api/votes?vote=yes', 'yes'),
            array('/api/votes?vote=no', 'no'),
        );
    }

    /**
     * @dataProvider votersCanViewVotesProvider
     */
    public function testVotersCanViewVotes($path, $value)
    {
        $this->loadFixtureFiles(array(
            '@AppBundle/DataFixtures/ORM/test.yml'
        ));
        $client = $this->createClientAuthenticatedAs('voter1');

        $client->request('GET', $path);

        $this->isSuccessful($client->getResponse());
        $this->assertJson($client->getResponse()->getContent());

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(
            array("id", "vote", "proposal"),
            array_keys($data['_embedded']['items'][0])
        );
        $this->assertEquals(
            array("id", "name", "_links"),
            array_keys($data['_embedded']['items'][0]["proposal"])
        );
        foreach ($data['_embedded']['items'] as $vote) {
            $this->assertEquals(
                $value,
                $vote["vote"]
            );
        }
    }
}
