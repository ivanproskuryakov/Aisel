<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Domain;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;

/**
 * QtyTrait
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 */
trait QtyTrait
{

    /**
     * @var integer
     * @Assert\NotNull()
     * @ODM\Field(type="string")
     * @JMS\Type("integer")
     */
    private $qty = 0;

    /**
     * Set qty
     *
     * @param  integer $qty
     * @return mixed
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return integer
     */
    public function getQty()
    {
        return $this->qty;
    }
}
