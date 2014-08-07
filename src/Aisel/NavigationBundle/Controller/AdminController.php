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
            'parentId' => $request->query->get('parentId'),
            'action' => $request->query->get('action'),
        );

        switch ($params['action']) {
            case 'save':
                $menu = $this->container->get("aisel.navigation.manager")->save($params);
                break;
            case 'remove':
                $menu = $this->container->get("aisel.navigation.manager")->remove($params);
                break;
            case 'addChild':
                $menu = $this->container->get("aisel.navigation.manager")->addChild($params);
                break;
            case 'addSibling':
                $menu = $this->container->get("aisel.navigation.manager")->addSibling($params);
                break;
            case 'dragDrop':
                $menu = $this->container->get("aisel.navigation.manager")->updateParent($params);
                break;
            default:
                $menu = null;
        }

        return $menu;


    }

}