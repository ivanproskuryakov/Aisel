<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Frontend users fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadFrontendUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Aisel Frontend user manager
     * @return \Aisel\UserBundle\Manager\UserManager
     */
    protected function getUserManager()
    {
        return $this->container->get('frontend.user.manager');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $random = rand(11111,99999);
        $time = time();

        $userData = array(
            'username'=>'frontenduser',
            'password'=>'frontenduser',
            'email'=>'frontenduser@aisel.co',
        );

        $user = $this->getUserManager()->registerUser($userData);

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}