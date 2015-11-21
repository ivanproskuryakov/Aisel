<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\Manager;

use LogicException;
use Aisel\OrderBundle\Entity\Invoice;
use Doctrine\ORM\EntityManager;
use Aisel\OrderBundle\Entity\Order;

/**
 * InvoiceManager
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class InvoiceManager
{

    /**
     * @var EntityManager
     */
    protected $dm;

    /**
     * Constructor
     *
     * @param EntityManager $EntityManager
     */
    public function __construct(EntityManager $EntityManager)
    {
        $this->dm = $EntityManager;
    }

    /**
     * Get single invoice by Id
     *
     * @param int $id
     *
     * @return Invoice $invoice
     *
     * @throws LogicException
     */
    public function getInvoice($id)
    {
        $invoice = $this->dm->getRepository('Aisel\OrderBundle\Entity\Invoice')->find($id);

        if (!($invoice)) {
            throw new LogicException('Nothing found');
        }

        return $invoice;
    }

    /**
     * Create invoice for order Id
     *
     * @param Order $order
     *
     * @return Invoice $invoice|false
     *
     */
    public function createInvoiceForOrder(Order $order)
    {
        if ($order) {

            if (!$order->getInvoice()) {
                $invoice = new Invoice();
                $this->dm->persist($invoice);
                $this->dm->flush();
                // Update order data
                $order->setInvoice($invoice);
                $this->dm->persist($order);
                $this->dm->flush();

                return $invoice;
            }
        }

        return false;
    }

}
