<?php

namespace Aisel\SettingsBundle\Controller;

use Aisel\ConfigBundle\Controller\SettingsController;

/**
 * Extends SettingsController for Meta settings in Backend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ConfigMetaController extends SettingsController
{

    public $form = "\Aisel\SettingsBundle\Form\Type\ConfigMetaType";

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
