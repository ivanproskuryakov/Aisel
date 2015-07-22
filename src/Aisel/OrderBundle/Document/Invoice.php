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

use JMS\Serializer\Annotation as JMS;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;

/**
 * Invoice
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_order_invoice",
 *      repositoryClass="Aisel\OrderBundle\Document\InvoiceRepository"
 * )
 * @ODM\MappedSuperclass
 */
class Invoice
{

    use UpdateCreateTrait;

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
