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
use Aisel\MediaBundle\Document\Image;

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
        $fs = new Filesystem();
        $uploadPath = realpath($this->container->getParameter('application.media.upload_path'));

        if ($fs->exists($uploadPath) === false) {
            $fs->mkdir($uploadPath);
        }

        $filename = Uploader::uploadFile($uploadPath, $request);

        if ($filename) {
            $path = sprintf("%s/%s",
                $this->container->getParameter('application.media.path'),
                $filename
            );

            $image = new Image();
            $image->setMainImage(true);
            $image->setFilename($path);
            $this->get('doctrine.odm.mongodb.document_manager')->persist($image);
            $this->get('doctrine.odm.mongodb.document_manager')->flush();

            $image = [
                'id' => $image->getId(),
                'filename' => $image->getFilename(),
            ];

            return new JsonResponse($image, 201);
        }
    }
}
