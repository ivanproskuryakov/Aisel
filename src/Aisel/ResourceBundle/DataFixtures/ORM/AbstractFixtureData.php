<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Abstract fixtures class
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
abstract class AbstractFixtureData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    protected $fixturesName = null;
    protected $container;
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->fixturesFile =
            dirname($container->getParameter('kernel.root_dir')) .
            $container->getParameter('application.dump.xml.path') . DIRECTORY_SEPARATOR .
            $this->fixturesName;

        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

}
