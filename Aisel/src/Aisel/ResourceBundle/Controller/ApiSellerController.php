<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Controller;

use Doctrine\ORM\EntityManager;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiSellerController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiSellerController extends ApiController
{

    /**
     * @param Request $request
     *
     * @return null|mixed $entity
     */
    protected function getEntityFromRequest(Request $request)
    {
        $configuration = new ParamConverter(array(
            'class' => $this->model,
            'options' => ['user' => $this->getUser()]
        ));
        $entity = $this
            ->get('api_param_converter')
            ->execute($request, $configuration);

        return $entity;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getCollectionAction(Request $request)
    {
        $params = array(
            'locale' => $request->get('locale'),
            'current' => $request->get('current'),
            'limit' => $request->get('limit'),
            'node' => $request->get('node'),
            'order' => $request->get('order'),
            'orderBy' => $request->get('orderBy'),
            'filter' => $request->get('filter'),
            'scope' => $this->getScope(),
            'user' => $this->getUser(),
        );

        /**
         * @var $repo \Aisel\ResourceBundle\Repository\CollectionRepository
         */
        $repo = $this
            ->getEntityManager()
            ->getRepository($this->model);
        $total = $repo->getTotalFromRequest($params);
        $collection = $repo->getCollection($params);

        return array(
            'total' => $total,
            'collection' => $this->filterMaxDepth($collection)
        );
    }

}
