<?php

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
