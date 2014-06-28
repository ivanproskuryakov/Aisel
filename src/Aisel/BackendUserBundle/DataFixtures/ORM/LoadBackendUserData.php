<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\BackendUserBundle\DataFixtures\ORM;

use Aisel\BackendUserBundle\Entity\BackendUser;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Backend users fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadBackendUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
     * Backend user manager for our nice operations.
     * @return \Aisel\BackendUserBundle\Manager\UserManager
     */
    protected function getUserManager()
    {
        return $this->container->get('backend.user.manager');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $userData = array(
            'username'=>'backenduser',
            'password'=>'backenduser',
            'email'=>'backenduser@aisel.co',
        );

        $this->getUserManager()->registerFixturesUser($userData);

        $userData = array(
            'username'=>'service',
            'password'=>'service',
            'email'=>'service@aisel.co',
        );

        $this->getUserManager()->registerFixturesUser($userData);

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
