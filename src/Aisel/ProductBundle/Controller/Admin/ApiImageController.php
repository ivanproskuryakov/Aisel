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

use Symfony\Component\HttpFoundation\Request;
use Aisel\ResourceBundle\Controller\ApiController as BaseApiController;
use Aisel\ResourceBundle\Media\Uploader;
use Aisel\ProductBundle\Entity\Image;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * ApiImageController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiImageController extends BaseApiController
{

    /**
     * @var string
     */
    protected $model = "Aisel\ProductBundle\Entity\Image";

    /**
     * uploadAction
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function uploadAction(Request $request)
    {
        $id = $request->query->get('id');
        $dir = realpath(sprintf(
            "%s/%s",
            $this->container->getParameter('application.media.product.upload_dir'),
            $id
        ));

        $result = Uploader::uploadFile($dir, $request);

        if ($result['status'] === false) {
            return new JsonResponse(204);
        }

        if ($result['file']) {
            return new JsonResponse($result['file'], 201);
        }
    }


}
