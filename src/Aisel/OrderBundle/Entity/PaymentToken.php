<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Token;

/**
 * PaymentToken
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Aisel\OrderBundle\Entity\PaymentTokenRepository")
 * @ORM\Table(name="aisel_order_payment_token")
 */
class PaymentToken extends Token
{

}
