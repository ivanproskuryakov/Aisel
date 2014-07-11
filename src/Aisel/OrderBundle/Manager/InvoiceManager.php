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

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Aisel\AdminBundle\Utility\UrlUtility;

/**
 * Manager for Orders, mostly used in REST API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class InvoiceManager
{
    protected $sc;
    protected $em;

    public function __construct($sc, $em)
    {
        $this->sc = $sc;
        $this->em = $em;
    }


    /**
     * Get single invoice by Id
     * @param  int $id
     * @return \Aisel\OrderBundle\Entity\Order $orderDetails
     */
    public function getInvoice($id)
    {
        $invoice = $this->em->getRepository('AiselOrderBundle:Invoice')->find($id);

        if (!($invoice)) {
            throw new NotFoundHttpException('Nothing found');
        }

        return $invoice;
    }


}
