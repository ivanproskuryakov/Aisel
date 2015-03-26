<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\Manager;

use LogicException;

/**
 * Addressing manager mostly used in API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class AddressingManager
{
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Get all countries
     *
     * @param array $params
     *
     * @return array $return
     */
    public function getCountries($params)
    {
        $total = $this->em->getRepository('AiselAddressingBundle:Country')->getTotalFromRequest($params);
        $collection = $this->em->getRepository('AiselAddressingBundle:Country')->getCollectionFromRequest($params);
        $return = array(
            'total' => $total,
            'collection' => $collection
        );

        return $return;
    }

    /**
     * Get country city by its id
     *
     * @param  integer $id
     * @return \Aisel\AddressingBundle\Entity\Country $countries
     *
     * @throws LogicException
     */
    public function getCountryById($id)
    {
        $country = $this->em->getRepository('AiselAddressingBundle:Country')->findOneBy(array('id' => $id));

        if (!($country)) {
            throw new LogicException('Nothing found');
        }

        return $country;
    }

    /**
     * Get cities
     *
     * @param array $params
     *
     * @return array $return
     */
    public function getCities($params)
    {
        $total = $this->em->getRepository('AiselAddressingBundle:City')->getTotalFromRequest($params);
        $collection = $this->em->getRepository('AiselAddressingBundle:City')->getCollectionFromRequest($params);
        $return = array(
            'total' => $total,
            'collection' => $collection
        );

        return $return;
    }

    /**
     * Get single city by its id
     *
     * @param  integer $id
     * @return \Aisel\AddressingBundle\Entity\City $countries
     *
     * @throws LogicException
     */
    public function getCityById($id)
    {
        $city = $this->em->getRepository('AiselAddressingBundle:City')->findOneBy(array('id' => $id));

        if (!($city)) {
            throw new LogicException('Nothing found');
        }

        return $city;
    }

    /**
     * Get regions
     *
     * @param array $params
     *
     * @return array $return
     */
    public function getRegions($params)
    {
        $total = $this->em->getRepository('AiselAddressingBundle:Region')->getTotalFromRequest($params);
        $collection = $this->em->getRepository('AiselAddressingBundle:Region')->getCollectionFromRequest($params);
        $return = array(
            'total' => $total,
            'collection' => $collection
        );

        return $return;

    }

    /**
     * Get single region by its id
     *
     * @param  integer $id
     * @return \Aisel\AddressingBundle\Entity\Region $region
     *
     * @throws LogicException
     */
    public function getRegionById($id)
    {
        $region = $this->em->getRepository('AiselAddressingBundle:Region')->findOneBy(array('id' => $id));

        if (!($region)) {
            throw new LogicException('Nothing found');
        }

        return $region;
    }

}
