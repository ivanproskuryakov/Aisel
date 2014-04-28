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

use Aisel\ConfigBundle\Entity\Setting;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * To implement settings fuctionality extend this class and set protected values
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class SettingsController extends Controller
{

    protected $form = null;

    protected $template = 'AiselConfigBundle:Settings:modify.html.twig';

    protected $templateVariables = array();

    /*
     * Main and single action
     * */
	public function modifyAction()
    {
        $request = $this->get('request');
        $routeId = $request->get('_route');


        $config = $this->getRepository()->getConfig($routeId);
        $form = $this->populateForm(new $this->form(), $config);

        $request = $this->get('request');
        if ($request->getMethod() === 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $formJson = json_encode($form->getData());

                if ($this->getRepository()->setConfig($routeId, $formJson)) {
                    $this->get('session')->getFlashBag()
                        ->set('notice',$this->get('translator')->trans('settings_changed.label', array(), 'AiselConfigBundle'));
                }
            }
        }

        $this->templateVariables['form'] = $form->createView();
        $this->templateVariables['routes'] = $this->getRoutes();
        $this->templateVariables['config_name'] = $this->getConfigNameLabel();

        return $this->render($this->template, $this->getTemplateVariables());

	}

	/**
     * Use this method if you need to pass additional variables for twig, in Aisel I use it to pass some Sonata vars
	 * @return array
	 */
    protected function getTemplateVariables()
    {
        return $this->$twig;
    }

	/**
	 * @return ConfigRepository
	 */
    protected function getRepository()
    {
        return $this->get('doctrine')->getRepository('AiselConfigBundle:Config');
    }

	/**
	 * @return Form
	 */
    protected function populateForm($formClass, $config)
    {
        $formArray = array();
        if ($config) {
            $formArray = json_decode($config->getValue(), true);
        }

        $form = $this->createForm(new $this->form(),$formArray);

        return $form;
    }

	/**
     * Return routes with their names
     *
	 * @return Array
	 */
    protected function getRoutes()
    {
        $configEntities = $this->container->getParameter('aisel_config.entities');
        $prefix = $this->container->getParameter('aisel_config.route_prefix');

        $routes = Array();
        asort($configEntities);
        foreach ($configEntities as $name => $value) {

            $_route = Array();
            $_route['name'] = 'aisel_config_'.$name.'.label';
            $_route['path'] = $prefix.$name;

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
        $label =  'aisel_'.$this->get('request')->get('_route').'.label';
        return $label;
    }


}
