<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ConfigBundle\Manager;

use Doctrine\ORM\EntityManager;
use LogicException;

/**
 * ConfigManager
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ConfigManager
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $locale = array();

    /**
     * Constructor
     *
     * @param EntityManager $em
     * @param string $locale
     * @param string $locales
     */
    public function __construct(EntityManager $em, $locale, $locales)
    {
        $this->em = $em;
        $this->locale['primary'] = $locale;
        $this->locale['available'] = explode('|', $locales);
    }

    /**
     * Get all settings
     *
     * @param string $locale
     *
     * @throws LogicException
     *
     * @return array $config
     */
    public function getConfig($locale = null)
    {
        $collection = $this->em->getRepository('AiselConfigBundle:Config')->getAllSettings($locale);

        if (!$collection) {
            throw new LogicException('Nothing found');
        }

        $config = array();
        foreach ($collection as $s) {

            $config['settings'][$s['locale']][$s['entity']] = json_decode($s['value'], true);
        }

        $config['locale'] = $this->locale;
        $config['time'] = time(); // inject timestamp

        return $config;
    }

    /**
     * Save config settings
     *
     * @param string $settingsData
     *
     * @return array $config
     */
    public function saveConfig($settingsData)
    {
        $settings = json_decode($settingsData, true);

        $this->em->getRepository('AiselConfigBundle:Config')->saveConfig($settings);
    }

    /**
     * Get all setting
     *
     * @param string $entity
     * @param string $locale
     *
     * @return array $config
     */
    public function getConfigForEntity($locale = null, $entity)
    {
        $config = $this->em
            ->getRepository('AiselConfigBundle:Config')
            ->getConfig($locale, $entity);

        $value = (array)json_decode($config->getValue());

        return $value;
    }

    /**
     * Prepare config data for later use in form
     *
     * @param string $config
     *
     * @return array $formArray
     */
    public function prepare($config)
    {
        $decoded = array();

        if ($config && $config) {
            $decoded = (array)json_decode($config->getValue());
        }

        return $decoded;
    }

}
