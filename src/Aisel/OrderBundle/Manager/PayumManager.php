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

/**
 * Wrapper for PayumBundle | Empty
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class PayumManager
{

    protected $sc;

    /**
     * {@inheritDoc}
     */
    public function __construct($serviceContainer)
    {
        $this->sc = $serviceContainer;
    }

    /**
     * Returns array of available payment methods
     * defined in payum.yml
     *
     * @return array $paymentMethods
     */
    public function getAvailablePaymentMethods()
    {
        return null;
    }

}
