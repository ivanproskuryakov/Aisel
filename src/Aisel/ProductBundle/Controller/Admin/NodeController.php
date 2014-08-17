<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Backend AJAX actions for product categories
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class NodeController extends Controller
{

    protected $nodeManager = "aisel.productcategory.node.manager";

    /**
     * AJAX update action for node with $id
     *
     * @param int     $id
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
                $menu = $this->container->get($this->nodeManager)->save($params);
                break;
            case 'remove':
                $menu = $this->container->get($this->nodeManager)->remove($params);
                break;
            case 'addChild':
                $menu = $this->container->get($this->nodeManager)->addChild($params);
                break;
            case 'addSibling':
                $menu = $this->container->get($this->nodeManager)->addSibling($params);
                break;
            case 'dragDrop':
                $menu = $this->container->get($this->nodeManager)->updateParent($params);
                break;
            default:
                $menu = null;
        }

        return $menu;

    }

}
