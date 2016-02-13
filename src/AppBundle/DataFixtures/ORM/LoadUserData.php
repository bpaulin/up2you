<?php
// Change the namespace!
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
  /**
   * @var ContainerInterface
   */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setUsername('proposer');
        $user->setEmail('proposer@domain.com');
        $user->setPlainPassword('proposer');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_PROPOSER'));
        $userManager->updateUser($user, true);

        $user = $userManager->createUser();
        $user->setUsername('voter');
        $user->setEmail('voter@domain.com');
        $user->setPlainPassword('voter');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_VOTER'));
        $userManager->updateUser($user, true);

        $user = $userManager->createUser();
        $user->setUsername('decider');
        $user->setEmail('decider@domain.com');
        $user->setPlainPassword('decider');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_DECIDER'));
        $userManager->updateUser($user, true);
    }
}
