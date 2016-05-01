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
use Symfony\Component\HttpFoundation\Request;

/**
 * ApiController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiController extends Controller
{

    /**
     * Get config data
     *
     * @return array $config
     */
    public function getAction()
    {
        $config = $this
            ->container
            ->get("aisel.config.manager")
            ->getConfig();

        $config['fields'] = $this
            ->container
            ->getParameter('aisel_config');

        return $config;
    }

    /**
     * Save config data
     *
     * @param Request $request
     *
     * @return array $config
     */
    public function saveAction(Request $request)
    {
        $settingsData = $request->getContent();
        $this
            ->container
            ->get("aisel.config.manager")
            ->saveConfig($settingsData);

        return array('status' => true, 'message' => 'Settings have been saved!');
    }

}
