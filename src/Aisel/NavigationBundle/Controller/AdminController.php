<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Page sort for Backend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class AdminController extends Controller
{

    /**
     * REST update action for menu with $id
     *
     * @param int $id
     * @param Request $request
     *
     */
    public function updateAction(Request $request)
    {
        $params = array(
            'name' => $request->query->get('name'),
            'id' => $request->query->get('id'),
        );

        $menu = $this->container->get("aisel.navigation.manager")->updateItem($params);
        return $menu;


    }

}