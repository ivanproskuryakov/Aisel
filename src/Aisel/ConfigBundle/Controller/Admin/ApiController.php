<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ConfigBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * ApiController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiController extends Controller
{

    /**
     * Config for backend
     *
     * @return array $config
     */
    public function getAction()
    {
        $container = $this->container;
        $config = $container->get("aisel.config.manager")->getConfig();
        $config['fields'] = $container->getParameter('aisel_config');

        return $config;
    }

}
