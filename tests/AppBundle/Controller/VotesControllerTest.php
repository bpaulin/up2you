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

    public function votersCanViewVotesProvider()
    {
        return array(
            array('/api/votes/maybe', 0),
            array('/api/votes/yes', 1),
            array('/api/votes/no', -1),
        );
    }

    /**
     * @dataProvider votersCanViewVotesProvider
     */
    public function testVotersCanViewVotesMaybe($path, $value)
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
            array_keys($data[0])
        );
        $this->assertEquals(
            array("id", "name"),
            array_keys($data[0]["proposal"])
        );
        foreach ($data as $vote) {
            $this->assertEquals(
                $value,
                $vote["vote"]
            );
        }
    }
}
