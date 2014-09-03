<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\ResourceBundle\DataFixtures\ORM\AbstractFixtureData;
use Aisel\OrderBundle\Entity\Order;

/**
 * Order fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadOrderData extends AbstractFixtureData implements OrderedFixtureInterface
{

    protected $fixturesName = 'aisel_order.xml';

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (file_exists($this->fixturesFile)) {
            $contents = file_get_contents($this->fixturesFile);
            $XML = simplexml_load_string($contents);

            foreach ($XML->database->table as $table) {
                $frontendUser = $this->getReference('frontenduser_'.$table->column[1]);
                $order = new Order();
                $order->setStatus($table->column[2]);
                $order->setSubtotal((float) $table->column[3]);
                $order->getGrandtotal((float) $table->column[4]);
                $order->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $order->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $order->setFrontenduser($frontendUser);
                $manager->persist($order);
                $manager->flush();
                $this->addReference('order' . $table->column[0], $order);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 600;
    }
}
