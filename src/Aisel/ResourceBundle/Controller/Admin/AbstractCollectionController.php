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
 * AbstractApiCollectionController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class AbstractCollectionController extends Controller
{

    protected $manager = '';

    /**
     * Get collection Manager
     *
     * @return mixed
     */
    protected function getManager()
    {
        return $this->container->get($this->manager);
    }

    /**
     * getCollectionAction
     *
     * @param Request $request
     *
     * @return $collection
     */
    public function getCollectionAction(Request $request)
    {
        $params = array(
            'current' => $request->get('current'),
            'limit' => $request->get('limit'),
            'category' => $request->get('category'),
            'filter' => $request->get('filter')
        );
        $manager = $this->getManager();
        $collection = $manager->getCollection($params);

        return $collection;
    }

    /**
     * @param integer $id
     *
     * @return mixed $item
     */
    public function deleteAction($id)
    {
        $this->getManager()->deleteItem($id);
    }

    /**
     * @param integer $id
     *
     * @return mixed $item
     */
    public function getAction($id)
    {
        return $this->getManager()->getItem($id);
    }

    /**
     * @param Request $request
     *
     * @return mixed $item
     */
    public function putAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        return $this->getManager()->saveItem($data);
    }

    /**
     * @return mixed $item
     */
    public function postAction(Request $request)
    {
        $data = (array)json_decode($request->getContent(), true);

        return $this->getManager()->saveItem($data);
    }

}
