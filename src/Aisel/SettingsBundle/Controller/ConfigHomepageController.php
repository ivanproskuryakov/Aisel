<?php

namespace Aisel\SettingsBundle\Controller;

use Aisel\ConfigBundle\Controller\SettingsController;

/**
 * Homepage settings controller for Backend, extends Aisel SettingsController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ConfigHomepageController extends SettingsController
{

    public $form = "\Aisel\SettingsBundle\Form\Type\ConfigHomepageType";

    /**
     * {@inheritdoc }
     */
    protected function getTemplateVariables()
    {
        $this->templateVariables['base_template'] = 'AiselSettingsBundle::layout.html.twig';
        $this->templateVariables['admin_pool'] = $this->container->get('sonata.admin.pool');
        $this->templateVariables['blocks'] = $this->container->getParameter('sonata.admin.configuration.dashboard_blocks');

        return $this->templateVariables;
    }

}
