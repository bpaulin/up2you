<?php

namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class BaseTestCase extends WebTestCase
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
  protected function createAuthenticatedClient($username = 'voter1', $password = 'voter1')
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

  protected function createClientAuthenticatedAs($user)
  {
    return $this->createAuthenticatedClient($user, $user);
  }
}