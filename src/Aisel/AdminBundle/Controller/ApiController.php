<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AdminBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Returns CMS settings in JSON format
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiController extends Controller
{

    /**
     * @Rest\View
     * /api/config/settings.json
     */
    public function configAction()
    {
        $config = $this->container->get("aisel.adminconfig.manager")->getConfig();
        return $config;

    }


}
