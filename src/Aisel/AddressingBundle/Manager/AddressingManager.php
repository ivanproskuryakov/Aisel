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

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    protected function getRepository()
    {
        return $this->em->getRepository('AiselBackendUserBundle:BackendUser');
    }

    /**
     * Get all countries
     *
     * @return \Aisel\AddressingBundle\Entity\Country $countries
     *
     * @throws NotFoundHttpException
     */
    public function getCountries()
    {
        $countries = $this->em->getRepository('AiselAddressingBundle:Country')->findAll();

        if (!($countries)) {
            throw new NotFoundHttpException('Nothing found');
        }

        return $countries;
    }

    /**
     * Get country city by its id
     *
     * @param  integer                                $id
     * @return \Aisel\AddressingBundle\Entity\Country $countries
     *
     * @throws NotFoundHttpException
     */
    public function getCountryById($id)
    {
        $country = $this
            ->em->getRepository('AiselAddressingBundle:Country')
            ->findOneBy(array('id' => $id));

        if (!($country)) {
            throw new NotFoundHttpException('Nothing found');
        }

        return $country;
    }

    /**
     * Get all cities
     *
     * @return \Aisel\AddressingBundle\Entity\City $citil
     *
     * @throws NotFoundHttpException
     */
    public function getCities()
    {
        $cities = $this->em->getRepository('AiselAddressingBundle:City')->findAll();

        if (!($cities)) {
            throw new NotFoundHttpException('Nothing found');
        }

        return $cities;
    }

    /**
     * Get single city by its id
     *
     * @param  integer                             $id
     * @return \Aisel\AddressingBundle\Entity\City $countries
     *
     * @throws NotFoundHttpException
     */
    public function getCityById($id)
    {
        $city = $this
            ->em->getRepository('AiselAddressingBundle:City')
            ->findOneBy(array('id' => $id));

        if (!($city)) {
            throw new NotFoundHttpException('Nothing found');
        }

        return $city;
    }

    /**
     * Get all regions
     *
     * @return \Aisel\AddressingBundle\Entity\Region $regions
     *
     * @throws NotFoundHttpException
     */
    public function getRegions()
    {
        $regions = $this->em->getRepository('AiselAddressingBundle:Region')->findAll();

        if (!($regions)) {
            throw new NotFoundHttpException('Nothing found');
        }

        return $regions;
    }

    /**
     * Get single region by its id
     *
     * @param  integer                               $id
     * @return \Aisel\AddressingBundle\Entity\Region $region
     *
     * @throws NotFoundHttpException
     */
    public function getRegionById($id)
    {
        $region = $this
            ->em->getRepository('AiselAddressingBundle:Region')
            ->findOneBy(array('id' => $id));

        if (!($region)) {
            throw new NotFoundHttpException('Nothing found');
        }

        return $region;
    }

}
