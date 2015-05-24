<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * AbstractNodeController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class AbstractNodeController extends Controller
{

    protected $nodeManager;

    /**
     * getNodeCollectionAction
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getNodeCollectionAction(Request $request)
    {
        $tree = $this
            ->container
            ->get($this->nodeManager)
            ->getNodesTree($request->get('locale'));

        return $tree;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function nodeEditAction(Request $request)
    {
        $nodeManager = $this->container->get($this->nodeManager);

        $params = array(
            'locale' => $request->query->get('locale'),
            'name' => $request->query->get('name'),
            'id' => $request->query->get('id'),
            'parentId' => $request->query->get('parentId'),
            'action' => $request->query->get('action'),
        );

        switch ($params['action']) {
            case 'save':
                return $nodeManager->save($params);
            case 'remove':
                return $nodeManager->remove($params);
            case 'addChild':
                return $nodeManager->addChild($params);
            case 'addSibling':
                return $nodeManager->addSibling($params);
            case 'dragDrop':
                return $nodeManager->updateParent($params);
        }

        return false;
    }

}
