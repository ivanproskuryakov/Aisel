<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Backend AJAX actions for page categories
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class NodeController extends Controller
{

    protected $nodeManager = "aisel.pagecategory.node.manager";

    /**
     * Load category tree
     *
     * @param Request $request
     *
     * @return array $tree
     */
    public function getAction(Request $request)
    {
        $nodes = $this
            ->container
            ->get($this->nodeManager)
            ->load(1);

        return $nodes;
    }

    /**
     * AJAX update action for node with $id
     *
     * @param Request $request
     *
     * @return object
     */
    public function updateAction(Request $request)
    {
        $params = array(
            'name' => $request->query->get('name'),
            'id' => $request->query->get('id'),
            'parentId' => $request->query->get('parentId'),
            'action' => $request->query->get('action'),
        );
        $nodeManager = $this->container->get($this->nodeManager);

        switch ($params['action']) {
            case 'save':
                $menu = $nodeManager->save($params);
                break;
            case 'remove':
                $menu = $nodeManager->remove($params);
                break;
            case 'addChild':
                $menu = $nodeManager->addChild($params);
                break;
            case 'addSibling':
                $menu = $nodeManager->addSibling($params);
                break;
            case 'dragDrop':
                $menu = $nodeManager->updateParent($params);
                break;
            default:
                $menu = null;
        }

        return $menu;
    }

}
