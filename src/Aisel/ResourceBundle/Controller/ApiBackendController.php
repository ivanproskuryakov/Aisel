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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\Serializer\SerializationContext;

/**
 * Class ApiBackendController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiBackendController extends ApiController
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
            'options' => [
                'backendUser' => $this->getUser()
            ]
        ));
        $entity = $this
            ->get('api_param_converter')
            ->execute($request, $configuration);

        return $entity;
    }

}
