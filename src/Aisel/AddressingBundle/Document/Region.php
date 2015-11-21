<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\Document;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\NameTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;

/**
 * Region
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_addressing_region",
 *      repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository"
 * )
 */
class Region
{

    use IdTrait;
    use NameTrait;
    use UpdateCreateTrait;


    /**
     * @var Country
     * @ODM\ReferenceOne(targetDocument="Aisel\AddressingBundle\Document\Country", nullable=true)
     * @JMS\Type("Aisel\AddressingBundle\Document\Country")
     */
    private $country;

    /**
     * Set country
     *
     * @param  Country $country
     * @return Region
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }
}
