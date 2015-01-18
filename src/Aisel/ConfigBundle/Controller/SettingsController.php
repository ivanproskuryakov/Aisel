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
    protected $formService = null;
    protected $locales = null;
    protected $template = 'AiselConfigBundle:Settings:modify.html.twig';
    protected $templateVariables = array();
    protected $twig = array();

    /**
     * Save & read config data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifyAction()
    {
        if ($this->formService) $formType = $this->get('aisel.settings.form.general');
        if ($this->form) $formType = new $this->form;

        $request = $this->get('request');
        $routeId = $request->get('_route');
        $editLocale = $request->get('editLocale');
        $config = $this->getRepository()->getConfig($editLocale, $routeId);
        $form = $this->createForm(
            $formType,
            $this->getManager()->prepare($config)
        );

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
        $this->templateVariables['form'] = $form->createView();
        $this->templateVariables['routes'] = $this->getManager()->getRoutes();
        $this->templateVariables['config_name'] = $this->getManager()->getConfigNameLabel($this->get('request')->get('_route'));
        $this->templateVariables['locales'] = $this->getManager()->getLocales();

        return $this->render($this->template, $this->getTemplateVariables());
    }

    /**
     * Pass vars to template and later use
     *
     * @return array
     */
    protected function getTemplateVariables()
    {
        return $this->templateVariables;
    }

    /**
     * Repository for config
     * @return \Aisel\ConfigBundle\Entity\ConfigRepository
     */
    private function getRepository()
    {
        return $this->get('doctrine')->getRepository('AiselConfigBundle:Config');
    }

    /**
     * Wrapper function for manager service
     * @return \Aisel\ConfigBundle\Manager\ConfigManager
     */
    private function getManager()
    {
        return $this->container->get("aisel.config.manager");
    }

}
