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

use Aisel\PageBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class AbstractCollectionController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class AbstractCollectionController extends Controller
{

    /**
     * @var string
     */
    protected $route = null;

    /**
     * @var string
     */
    protected $entity = null;

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->get('doctrine.orm.entity_manager');
    }

    protected function getRouteNameFor($method)
    {
        $method = strtolower($method);

        return sprintf('%s_%s', $this->route, $method);
    }

    public function postAction(Request $request)
    {
        $configuration = new ParamConverter(array());
        $configuration->setName('page');
        $configuration->setClass($this->entity);
        $entity = $this->get('api_param_converter')->execute($request, $configuration);

        return $this->processEntity($entity);
    }

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
            $response->headers->set(
                'Location',
                $this->generateUrl(
                    $this->getRouteNameFor('GET'),
                    array('id' => $entity->getId()),
                    true // absolute
                )
            );
        }

        return $response;
    }

}
