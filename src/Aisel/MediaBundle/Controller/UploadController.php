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

use Aisel\MediaBundle\Service\Uploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Filesystem\Filesystem;

/**
 * UploadController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class UploadController extends Controller
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
        $productDir = realpath($this->container->getParameter('application.media.product.upload_dir'));
        $uploadDir = $productDir . '/' . $id;
        $fs = new Filesystem();

        if ($fs->exists($uploadDir) === false) {
            $fs->mkdir($uploadDir);
        }

        $filename = Uploader::uploadFile($uploadDir, $request);

        if ($filename) {
            $path = sprintf(
                "%s/%s/%s",
                $this->container->getParameter('application.media.product.upload_path'),
                $id,
                $filename
            );

            return new JsonResponse($path, 201);
        }

    }

}
