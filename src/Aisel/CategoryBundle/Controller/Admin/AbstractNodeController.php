<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CategoryBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Backend AJAX actions for page categories
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class AbstractNodeController extends Controller
{

    protected $nodeManager;

    /**
     * @param integer $id
     *
     * @return JsonResponse $response
     */
    public function getAction($id)
    {
        $nodeManager = $this->container->get($this->nodeManager);

        return $nodeManager->getItem($id);
    }

    /**
     * Load tree
     *
     * @param Request $request
     *
     * @return array
     */
    public function getTreeAction(Request $request)
    {
        $locale = $request->query->get('locale');
        $nodes = $this
            ->container
            ->get($this->nodeManager)
            ->getTree($locale);

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
                $node = $nodeManager->save($params);
                break;
            case 'remove':
                $node = $nodeManager->remove($params);
                break;
            case 'addChild':
                $node = $nodeManager->addChild($params);
                break;
            case 'addSibling':
                $node = $nodeManager->addSibling($params);
                break;
            case 'dragDrop':
                $node = $nodeManager->updateParent($params);
                break;
            default:
                $node = null;
        }

        return $node;
    }

}
