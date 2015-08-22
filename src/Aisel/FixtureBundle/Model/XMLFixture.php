<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\FixtureBundle\Model;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Abstract fixtures class for XML fixtures
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
abstract class XMLFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    protected $fixturesName = array();
    protected $fixtureFiles = array();
    protected $container;
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $files = array();

        foreach ($this->fixturesName as $key => $file) {
            $files[$key] = dirname($container->getParameter('kernel.root_dir')) .
                $container->getParameter('aisel_fixture.xml.path') . DIRECTORY_SEPARATOR .
                $file;
        }
        $this->fixtureFiles = $files;
    }

}
