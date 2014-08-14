<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\DataFixtures\ORM;

use Aisel\AddressingBundle\Entity\Country;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Country fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadCountryData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $connection = $manager->getConnection();

        $kernel = $this->container->get('kernel');
        $pathCountySQL = $kernel->locateResource('@AiselAddressingBundle/Resources/sql/country.sql');
        $countrySQL = file_get_contents($pathCountySQL);
        $connection->exec($countrySQL);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 500;
    }
}
