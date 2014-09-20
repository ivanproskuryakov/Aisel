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
use Aisel\OrderBundle\Entity\Invoice;

/**
 * Order fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadInvoiceData extends XMLFixtureData implements OrderedFixtureInterface
{

    protected $fixturesName = 'aisel_invoice.xml';

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (file_exists($this->fixturesFile)) {
            $contents = file_get_contents($this->fixturesFile);
            $XML = simplexml_load_string($contents);

            foreach ($XML->database->table as $table) {
                $invoice = new Invoice();
                $invoice->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $invoice->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $manager->persist($invoice);
                $manager->flush();
                $this->addReference('invoice_' . $table->column[0], $invoice);
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
