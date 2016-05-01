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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
     * @param string $type
     *
     * @return mixed
     */
    public function uploadAction(Request $request, $type)
    {
        $path = Uploader::uploadFile(
            realpath($this->container->getParameter('application.media.upload_path')),
            $request
        );

        if ($path) {
            $media = $this
                ->container
                ->get('aisel.media.manager')
                ->createMediaFromFile($path, $type);

            $file = [
                'id' => $media->getId(),
                'filename' => $media->getFilename(),
            ];

            return new JsonResponse($file, 201);
        }
    }
}
