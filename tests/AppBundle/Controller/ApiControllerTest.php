<?php

namespace AppBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     *
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient($username = 'proposer', $password = 'proposer')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            array(
                'username' => $username,
                'password' => $password,
            )
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    public function testProposerCanPing()
    {
        $this->loadFixtures(array(
            'AppBundle\DataFixtures\ORM\LoadUserData'
        ));
        $client = $this->createAuthenticatedClient();

        $client->request('GET', '/api/ping');

        $this->assertTrue(
            $client->getResponse()->isSuccessful()
        );
    }

    public function testAnonymousCantPing()
    {
        $this->loadFixtures(array(
            'AppBundle\DataFixtures\ORM\LoadUserData'
        ));
        $client = static::createClient();

        $client->request('GET', '/api/ping');

        $this->assertFalse(
            $client->getResponse()->isSuccessful()
        );
    }
}
