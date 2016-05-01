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

use Aisel\OrderBundle\Entity\Invoice;
use Aisel\OrderBundle\Entity\Order;
use Doctrine\ORM\EntityManager;
use LogicException;

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
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
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
        $invoice = $this->em->getRepository('Aisel\OrderBundle\Entity\Invoice')->find($id);

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
                $this->em->persist($invoice);
                $this->em->flush();
                // Update order data
                $order->setInvoice($invoice);
                $this->em->persist($order);
                $this->em->flush();

                return $invoice;
            }
        }

        return false;
    }

}
