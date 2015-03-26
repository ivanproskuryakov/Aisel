<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\SettingsBundle\Manager;

use LogicException;

/**
 * Manager to retrieve CMS settings
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class SettingsManager
{
    protected $em;
    protected $locale = array();

    /**
     * {@inheritDoc}
     */
    public function __construct($em, $locale, $locales)
    {
        $this->em = $em;
        $this->locale['primary'] = $locale;
        $this->locale['available'] = explode('|', $locales);
    }

    /**
     * Get all setting
     *
     * @param string $locale
     *
     * @return array $config
     *
     * @throws LogicException
     */
    public function getConfig($locale = null)
    {
        $config = $this->em->getRepository('AiselConfigBundle:Config')->getAllSettings($locale);

        if (!($config)) {
            throw new LogicException('Nothing found');
        }
        $config['settings'] = array();
        $config['settings']['locale'] = $this->locale;
        $config['time'] = time(); // inject response unix timestamp

        return $config;
    }

    /**
     * Get all setting
     *
     * @param string $entity
     * @param string $locale
     *
     * @return array $config
     *
     * @throws LogicException
     */
    public function getConfigForEntity($locale = null, $entity)
    {
        $config = $this->em
            ->getRepository('AiselConfigBundle:Config')
            ->getConfig($locale, $entity);
        $value = (array) json_decode($config->getValue());

        return $value;
    }

}
