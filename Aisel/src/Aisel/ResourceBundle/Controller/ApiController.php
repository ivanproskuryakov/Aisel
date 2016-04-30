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
 * Class ApiController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiController extends Controller
{

    CONST SCOPE_FRONTEND = 'frontend';
    CONST SCOPE_SELLER = 'seller';
    CONST SCOPE_BACKEND = 'backend';

    /**
     * @var string
     */
    protected $model;

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        return $em;
    }

    /**
     * filterMaxDepth
     *
     * @param mixed $entity
     *
     * @return mixed $entity
     */
    protected function filterMaxDepth($entity)
    {

        $entity = $this
            ->container
            ->get('jms_serializer')
            ->serialize(
                $entity,
                'json',
                SerializationContext::create()->enableMaxDepthChecks()
            );


        return json_decode($entity, true);
    }

    /**
     *
     * getByURLAction
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getURLAction(Request $request)
    {
        $entity = $this->getEntityFromRequest($request);

        return $this->filterMaxDepth($entity);
    }

    /**
     * @param Request $request
     *
     * @return null|mixed $entity
     */
    protected function getEntityFromRequest(Request $request)
    {
        $configuration = new ParamConverter(array(
            'class' => $this->model
        ));
        $entity = $this->get('api_param_converter')->execute($request, $configuration);

        return $entity;
    }

    /**
     * @param $entity
     * @param null $id
     *
     * @return Response
     */
    protected function processEntity($entity, $id = null)
    {
        if ($id) {
            $statusCode = 204;
        } else {
            $statusCode = (null === $entity->getId()) ? 201 : 204;
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        $response = new Response();
        $response->setStatusCode($statusCode);

        // set the `Location` header only when creating new resources
        if (201 === $statusCode) {
            $route = str_replace(
                "_post",
                '_get',
                $this->get('request_stack')->getCurrentRequest()->get('_route')
            );

            if ($this->getScope() == self::SCOPE_BACKEND) {
                $url = $this->generateUrl(
                    $route,
                    array('id' => $entity->getId()),
                    true // absolute
                );
            }

            if ($this->getScope() == self::SCOPE_FRONTEND || $this->getScope() == self::SCOPE_SELLER) {
                $url = $this->generateUrl(
                    $route,
                    array(
                        'id' => $entity->getId(),
                        'locale' => $entity->getLocale()
                    ),
                    true // absolute
                );
            }

            $response
                ->headers
                ->set('Location', $url);
        }

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function putAction(Request $request)
    {
        $entity = $this->getEntityFromRequest($request);
        $this->processEntity($entity);
    }

    /**
     * postAction
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postAction(Request $request)
    {
        $entity = $this->getEntityFromRequest($request);

        return $this->processEntity($entity);
    }

    /**
     * getAction
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getAction(Request $request)
    {
        $entity = $this->getEntityFromRequest($request);

        return $this->filterMaxDepth($entity);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function getByURLAction(Request $request)
    {
        $entity = $this->getEntityFromRequest($request);

        return $this->filterMaxDepth($entity);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function deleteAction(Request $request)
    {
        $document = $this->getEntityFromRequest($request);
        $em = $this->getEntityManager();

        $em->remove($document);
        $em->flush();
        $em->clear();
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
            'scope' => $this->getScope()
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

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getTreeAction(Request $request)
    {
        $params = array(
            'locale' => $request->get('locale'),
            'scope' => $this->getScope()
        );

        /**
         * @var $repo \Aisel\ResourceBundle\Repository\CollectionRepository
         */
        $repo = $this
            ->getEntityManager()
            ->getRepository($this->model);
        $collection = $repo->getCollectionAsTree($params);

        return $collection;
    }

    /**
     * Get request scope
     *
     * @return string $status
     */
    protected function getScope()
    {
        $scope = self::SCOPE_BACKEND;

        $uri = $this->get('request_stack')->getCurrentRequest()->getUri();

        if (strpos($uri, $this->container->getParameter('frontend_api'))) {
            $scope = self::SCOPE_FRONTEND;
        }
        if (strpos($uri, $this->container->getParameter('seller_api'))) {
            $scope = self::SCOPE_SELLER;
        }

        return $scope;
    }

}
