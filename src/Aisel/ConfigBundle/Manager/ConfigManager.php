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

/**
 * Class mainly used in SettingsController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ConfigManager
{
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function __construct($sc)
    {
        $this->container = $sc;
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
            $decoded = (array) json_decode($config->getValue());
        }

        return $decoded;
    }

    /**
     * Return routes with their names
     *
     * @return array $routes
     */
    public function getRoutes()
    {
        $configEntities = $this->container->getParameter('aisel_config.entities');
        $prefix = $this->container->getParameter('aisel_config.route_prefix');
        $routes = array();
        asort($configEntities);

        foreach ($configEntities as $name => $value) {
            $_route = array();
            $_route['name'] = 'aisel_config_' . $name . '.label';
            $_route['path'] = $prefix . $name;
            $routes[] = $_route;
        }

        return $routes;
    }

    /**
     * Return config name
     *
     * @param string $route
     *
     * @return Array
     */
    public function getConfigNameLabel($route)
    {
        $label = 'aisel_' . $route . '.label';

        return $label;
    }

    /**
     * Get locales param from parameters
     *
     * @return array $this->locales
     */
    public function getLocales()
    {
        $localesParam = $this->container->getParameter('locales');
        $locales = explode('|', $localesParam);

        foreach ($locales as $locale) {
            $this->locales[$locale] = $locale;
        }
        $this->locales = $locales;

        return $this->locales;
    }
}
