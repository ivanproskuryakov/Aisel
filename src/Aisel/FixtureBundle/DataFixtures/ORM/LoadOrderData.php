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
use Aisel\OrderBundle\Entity\Order;

/**
 * Order fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadOrderData extends XMLFixtureData implements OrderedFixtureInterface
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
                $frontendUser = $this->getReference('frontenduser_'.$table->column[2]);
                $invoice = $this->getReference('invoice_'.$table->column[3]);
                $order = new Order();
                $order->setLocale($table->column[1]);
                $order->setStatus($table->column[4]);
                $order->setSubtotal((float) $table->column[5]);
                $order->getGrandtotal((float) $table->column[6]);
                $order->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $order->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $order->setFrontenduser($frontendUser);
                $order->setInvoice($invoice);
                $manager->persist($order);
                $manager->flush();
                $this->addReference('order_' . $table->column[0], $order);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 610;
    }
}
