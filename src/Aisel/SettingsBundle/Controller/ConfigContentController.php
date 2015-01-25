<?php

namespace Aisel\SettingsBundle\Controller;

use Aisel\ConfigBundle\Controller\SettingsController;

/**
 * Content settings controller for Backend, extends Aisel SettingsController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ConfigContentController extends SettingsController
{

    public $form = "\Aisel\SettingsBundle\Form\Type\ConfigContentType";

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
