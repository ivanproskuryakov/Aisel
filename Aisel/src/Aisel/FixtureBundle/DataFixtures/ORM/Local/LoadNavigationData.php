<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\FixtureBundle\DataFixtures\ORM\Local;

use Aisel\FixtureBundle\Model\XMLFixture;
use Aisel\NavigationBundle\Entity\Menu;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Navigation menu fixtures
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class LoadNavigationData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array(
        'en/aisel_menu_top.xml',
        'ru/aisel_menu_top.xml',
        'es/aisel_menu_top.xml',
    );

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

                    $rootNode = null;
                    if ($table->column[2] != 'NULL') {
                        $rootNode = $this->getReference('menu_top_' . $table->column[2]);
                    }
                    $menu = new Menu();
                    $menu->setLocale($table->column[1]);
                    $menu->setName($table->column[7]);
                    $menu->setMetaUrl($table->column[8]);
                    $menu->setStatus((int)$table->column[9]);

                    if ($rootNode) {
                        $menu->setParent($rootNode);
                    }
                    $manager->persist($menu);
                    $manager->flush();
                    $this->addReference('menu_top_' . $table->column[0], $menu);
                }
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
