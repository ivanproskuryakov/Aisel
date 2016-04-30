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

use Aisel\FixtureBundle\Model\XMLFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Order fixtures
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class LoadInvoiceData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array('global/aisel_invoice.xml');

    /**
     * Invoice manager
     * @return \Aisel\OrderBundle\Manager\InvoiceManager
     */
    protected function getInvoiceManager()
    {
        return $this->container->get('aisel.invoice.manager');
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
                    $order = $this->getReference('order_' . $table->column[1]);
                    $invoice = $this->getInvoiceManager()->createInvoiceForOrder($order);
                    $this->addReference('invoice_' . $table->column[0], $invoice);
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 420;
    }
}
