<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license infODMation, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Domain;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;

/**
 * IdTrait
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 */
trait IdTrait
{

    /**
     * @var string
     * @ODM\Id
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $id;

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
