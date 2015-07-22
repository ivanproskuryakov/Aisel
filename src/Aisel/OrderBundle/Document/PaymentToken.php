<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Payum\Core\Model\Token;
use JMS\Serializer\Annotation as JMS;

/**
 * PaymentToken
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_order_payment_token",
 *      repositoryClass="Aisel\OrderBundle\Document\PaymentTokenRepository"
 * )
 * @ODM\MappedSuperclass
 */
class PaymentToken extends Token
{

    /**
     * @var string
     * @ODM\Id
     * @JMS\Type("string")
     */
    private $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
