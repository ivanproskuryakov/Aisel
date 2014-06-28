<?php

namespace Aisel\AdminBundle\Controller;

use Aisel\ConfigBundle\Controller\SettingsController;

/**
 * Extends SettingsController for Disqus
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ConfigDisqusController extends SettingsController
{

    public $form = "\Aisel\AdminBundle\Form\Type\ConfigDisqusType";

    /**
     * {@inheritdoc }
     */
    protected function getTemplateVariables()
    {
        $this->templateVariables['base_template'] = 'AiselAdminBundle::layout.html.twig';
        $this->templateVariables['admin_pool']    = $this->container->get('sonata.admin.pool');
        $this->templateVariables['blocks']        = $this->container->getParameter('sonata.admin.configuration.dashboard_blocks');

        return $this->templateVariables;
    }

}
