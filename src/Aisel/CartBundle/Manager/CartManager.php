<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CartBundle\Manager;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Manager for Cart, mostly used in REST API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class CartManager
{
    protected $sc;
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function __construct($sc, $em)
    {
        $this->sc = $sc;
        $this->em = $em;
    }

    /**
     * Get single detailed cart object
     *
     * @param int $id
     *
     * @return \Aisel\CartBundle\Entity\Cart $cart
     *
     * @throws NotFoundHttpException
     */
    public function getCart($id)
    {
        $cart = $this->em->getRepository('AiselCartBundle:Cart')->find($id);

        if (!($cart)) {
            throw new NotFoundHttpException('Nothing found');
        }

        return $cart;
    }

}
