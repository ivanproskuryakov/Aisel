<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\SettingsBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Returns CMS settings in JSON format
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiSettingsController extends Controller
{

    /**
     * @Rest\View
     * /api/config/settings.json
     */
    public function configAction()
    {
        $config = $this->container->get("aisel.settings.manager")->getConfig();
        return $config;
    }

}
