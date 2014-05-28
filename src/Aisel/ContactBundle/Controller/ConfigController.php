<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ContactBundle\Controller;

use Aisel\ConfigBundle\Controller\SettingsController;

/**
 * Contact settings controller for Backend, extends Aisel SettingsController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ConfigController extends SettingsController
{

    public $form = "\Aisel\ContactBundle\Form\Type\ConfigType";

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
