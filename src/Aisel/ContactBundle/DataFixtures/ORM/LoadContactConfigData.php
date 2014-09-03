<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ContactBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\ResourceBundle\DataFixtures\ORM\AbstractFixtureData;
use Aisel\ConfigBundle\Entity\Config;

/**
 * Config fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadContactConfigData extends AbstractFixtureData implements OrderedFixtureInterface
{
    protected $fixturesName = 'aisel_config_contact.xml';

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
                $config->setEntity($table->column[1]);
                $config->setValue($table->column[2]);
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
