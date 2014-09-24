<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * To implement settings functionality extend class
 * and override protected vars
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class SettingsController extends Controller
{

    protected $form = null;
    protected $locales = null;
    protected $template = 'AiselConfigBundle:Settings:modify.html.twig';
    protected $templateVariables = array();

    /**
     * Saves & reads config data
     *
     * @return Response
     */
    public function modifyAction()
    {
        $request = $this->get('request');
        $routeId = $request->get('_route');
        $editLocale = $request->get('editLocale');
        $config = $this->getRepository()->getConfig($editLocale, $routeId);
        $form = $this->populateForm(new $this->form(), $config);

        if ($request->getMethod() === 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $formJson = json_encode($form->getData());

                if ($this->getRepository()->setConfig($editLocale, $routeId, $formJson)) {
                    $this->get('session')->getFlashBag()
                        ->set('notice', $this->get('translator')->trans('settings_changed.label', array(), 'AiselConfigBundle'));
                }
            }
        }
        $this->templateVariables['locales'] = $this->getLocales();
        $this->templateVariables['form'] = $form->createView();
        $this->templateVariables['routes'] = $this->getRoutes();
        $this->templateVariables['config_name'] = $this->getConfigNameLabel();

        return $this->render($this->template, $this->getTemplateVariables());
    }

    /**
     * Pass vars to template and later use
     *
     * @return array
     */
    protected function getTemplateVariables()
    {
        return $this->$twig;
    }

    /**
     * Repository for config
     * @return ConfigRepository
     */
    protected function getRepository()
    {
        return $this->get('doctrine')->getRepository('AiselConfigBundle:Config');
    }

    /**
     * Populate form with values from database
     *
     * @param string $formClass
     * @param string $config
     *
     * @return $this->form
     */
    protected function populateForm($formClass, $config)
    {
        $formArray = array();

        if ($config && $config[0]['value']) {
            $formArray = json_decode($config[0]['value']);
        }
        $form = $this->createForm(new $this->form(), $formArray);

        return $form;
    }

    /**
     * Return routes with their names
     *
     * @return array $routes
     */
    protected function getRoutes()
    {
        $configEntities = $this->container->getParameter('aisel_config.entities');
        $prefix = $this->container->getParameter('aisel_config.route_prefix');
        $routes = Array();
        asort($configEntities);

        foreach ($configEntities as $name => $value) {

            $_route = Array();
            $_route['name'] = 'aisel_config_' . $name . '.label';
            $_route['path'] = $prefix . $name;

            $routes[] = $_route;
        }

        return $routes;
    }

    /**
     * Return config name
     *
     * @return Array
     */
    protected function getConfigNameLabel()
    {
        $label = 'aisel_' . $this->get('request')->get('_route') . '.label';

        return $label;
    }

    /**
     * Get locales param from parameters
     *
     * @return array $this->locales
     */
    protected function getLocales()
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
