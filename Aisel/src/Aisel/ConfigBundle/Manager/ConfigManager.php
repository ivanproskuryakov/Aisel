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
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ConfigManager
{


    /**
     * @var string
     */
    protected $model = 'Aisel\ConfigBundle\Entity\Config';

    /**
     * @var EntityManager
     */
    protected $dm;

    /**
     * @var array
     */
    protected $locale = array();

    /**
     * Constructor
     *
     * @param EntityManager $dm
     * @param string $locale
     * @param string $locales
     */
    public function __construct(EntityManager $dm, $locale, $locales)
    {
        $this->dm = $dm;
        $this->locale['primary'] = $locale;
        $this->locale['available'] = explode('|', $locales);
    }

    /**
     * Get all settings
     *
     * @param string $locale
     * @throws LogicException
     *
     * @return array $config
     */
    public function getConfig($locale = null)
    {
        $collection = $this
            ->dm
            ->getRepository($this->model)
            ->getAllSettings($locale);

        if (!$collection) {
            throw new LogicException('Nothing found');
        }
        $config = array();

        foreach ($collection as $s) {
            $config['settings'][$s['locale']][$s['entity']] = json_decode($s['value'], true);
        }
        $config['locale'] = $this->locale;

        return $config;
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
    public function getConfigFrontend($locale)
    {
        if (in_array($locale, $this->locale['available']) === false) {
            $locale = $this->locale['primary'];
        }

        $collection = $this
            ->dm
            ->getRepository($this->model)
            ->getAllSettings($locale);

        $config = array();

        foreach ($collection as $s) {
            $config[$s['entity']] = json_decode($s['value'], true);
        }
        $config['locale'] = $this->locale;

        return $config;
    }

    /**
     * Save config settings
     *
     * @param string $settingsData
     * @return array $config
     */
    public function saveConfig($settingsData)
    {
        $settings = json_decode($settingsData, true);

        $this->dm
            ->getRepository($this->model)
            ->saveConfig($settings);
    }

    /**
     * Get all setting
     *
     * @param string $entity
     * @param string $locale
     * @return array $config
     */
    public function getConfigForEntity($locale = null, $entity)
    {
        $config = $this->dm
            ->getRepository($this->model)
            ->getConfig($locale, $entity);

        $value = (array)json_decode($config->getValue());

        return $value;
    }

    /**
     * Prepare config data for later use in form
     *
     * @param array $config
     * @return array $decoded
     */
    public function prepare(array $config)
    {
        $decoded = array();

        if ($config && $config) {
            $decoded = (array)json_decode($config->getValue());
        }

        return $decoded;
    }

}
