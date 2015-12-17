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
use Aisel\FixtureBundle\Model\XMLFixture;

/**
 * LoadFrontendUserData
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class LoadFrontendUserData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array('global/aisel_user_frontend.xml');

    /**
     * Frontend user manager
     * @return \Aisel\FrontendUserBundle\Manager\UserManager
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
        foreach ($this->fixtureFiles as $file) {

            if (file_exists($file)) {
                $contents = file_get_contents($file);
                $XML = simplexml_load_string($contents);

                foreach ($XML->database->table as $table) {
                    $userData = array(
                        'username' => (string)$table->column[1],
                        'email' => (string)$table->column[2],
                        'password' => (string)$table->column[3],
                        'enabled' => (string)$table->column[4],
                        'locked' => (string)$table->column[5],

                        'about' => (string)$table->column[10],
                        'phone' => (string)$table->column[11],
                        'website' => (string)$table->column[12],
                        'facebook' => (string)$table->column[13],
                        'twitter' => (string)$table->column[14]
                    );

                    $user = $this->getUserManager()->registerFixturesUser($userData);
                    $this->addReference('frontenduser_' . $table->column[0], $user);
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 100;
    }
}
