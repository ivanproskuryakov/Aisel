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
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * UpdateCreate
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 *
 */
trait UpdateCreate
{

    /**
     * @var \DateTime
     * @ODM\Field(type="date")
     * @Gedmo\Timestampable(on="create")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ODM\Field(type="date")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     */
    protected $updatedAt;


    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return mixed
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param  \DateTime $updatedAt
     * @return mixed
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

}
