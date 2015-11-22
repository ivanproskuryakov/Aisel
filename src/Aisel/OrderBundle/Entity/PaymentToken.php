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
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Domain\IdTrait;

/**
 * PaymentToken
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="aisel_order_payment_token")
 * @ORM\Entity(repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository")
 * @JMS\ExclusionPolicy("all")
 */
class PaymentToken extends Token
{

    use IdTrait;

}
