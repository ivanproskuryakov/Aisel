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
use Aisel\MediaBundle\Document\Media;

/**
 * UploadController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class UploadController extends Controller
{

    /**
     * createMedia
     *
     * @param string $filename
     * @param string $type
     *
     * @return Media $media
     */
    protected function newFile($filename, $type)
    {
        $path = sprintf("%s/%s",
            $this->container->getParameter('application.media.path'),
            $filename
        );

        $file = new Media();
        $file->setType($type);
        $file->setMainImage(true);
        $file->setFilename($path);
        $this->get('doctrine.odm.mongodb.document_manager')->persist($file);
        $this->get('doctrine.odm.mongodb.document_manager')->flush();

        $media = [
            'id' => $file->getId(),
            'filename' => $file->getFilename(),
        ];

        return $media;
    }

    /**
     * uploadAction
     *
     * @param Request $request
     * @param string $type
     *
     * @return mixed
     */
    public function uploadAction(Request $request, $type)
    {
        $fs = new Filesystem();
        $uploadPath = realpath($this->container->getParameter('application.media.upload_path'));

        if ($fs->exists($uploadPath) === false) {
            $fs->mkdir($uploadPath);
        }

        $filename = Uploader::uploadFile($uploadPath, $request);

        if ($filename) {
            $file = $this->newFile($filename, $type);

            return new JsonResponse($file, 201);
        }
    }
}
