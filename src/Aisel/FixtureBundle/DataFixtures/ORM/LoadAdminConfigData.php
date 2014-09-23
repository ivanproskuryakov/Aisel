<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\FixtureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\FixtureBundle\DataFixtures\XMLFixtureData;
use Aisel\ConfigBundle\Entity\Config;

/**
 * Config fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadAdminConfigData extends XMLFixtureData implements OrderedFixtureInterface
{

    protected $fixturesName = 'aisel_config_admin.xml';

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (file_exists($this->fixturesFile)) {
            $contents = file_get_contents($this->fixturesFile);
            $XML = simplexml_load_string($contents);
            $city = null;

            foreach ($XML->database->table as $table) {

                $config = new Config();
                $config->setlocale($table->column[1]);
                $config->setEntity($table->column[2]);
                $config->setValue($table->column[3]);
                $manager->persist($config);
                $manager->flush();
            }
        }

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 900;
    }
}
