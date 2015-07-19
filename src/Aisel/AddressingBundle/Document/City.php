<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license infODMation, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\Document;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;

/**
 * City
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 * repositoryClass="Aisel\AddressingBundle\Entity\CityRepository",
 * collection="aisel_addressing_city"
 * )
 */
class City
{
    /**
     * @var string
     * @ODM\Id
     * @JMS\Type("string")
     */
    private $id;

    /**
     * @var \DateTime
     * @ODM\Date
     * @Gedmo\Timestampable(on="create")
     * @JMS\Type("DateTime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ODM\Date
     * @Gedmo\Timestampable(on="update")
     * @JMS\Type("DateTime")
     */
    private $updatedAt;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

}
