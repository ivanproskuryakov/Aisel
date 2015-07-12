<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\MediaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Aisel\MediaBundle\Service\Uploader;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * ApiImageController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiImageController extends Controller
{

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
            $path = sprintf(
                "%s/%s/%s",
                $this->container->getParameter('application.media.product.upload_path'),
                $id,
                $result['file']
            );

            return new JsonResponse($path, 201);
        }
    }

}
