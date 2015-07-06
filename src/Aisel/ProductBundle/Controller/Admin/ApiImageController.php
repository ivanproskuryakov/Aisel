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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
     * @param int $id
     * @param Request $request
     *
     * @return mixed
     */
    public function uploadAction($id, Request $request)
    {
        $uploadDir = realpath(sprintf(
            "%s/%s",
            $this->container->getParameter('application.media.product.upload_dir'),
            $id
        ));
        $config = new \Flow\Config();
        $config->setTempDir($uploadDir);

        $uploadedRequest = null;
        $uploadedFile = null;

        if ($request->files->get('file')) {
            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $fileFromFileBag */
            $fileFromFileBag = $request->files->get('file');
            $uploadedFile = array(
                'name' => $fileFromFileBag->getClientOriginalName(),
                'type' => $fileFromFileBag->getMimeType(),
                'tmp_name' => $fileFromFileBag->getPathname(),
                'error' => $fileFromFileBag->getError(),
                'size' => $fileFromFileBag->getSize()
            );
        }

        if ($request->query->all()) {
            $uploadedRequest = $request->query->all();
        }
        if ($request->request->all()) {
            $uploadedRequest = $request->request->all();
        }

        $flowRequest = new \Flow\Request(
            $uploadedRequest,
            $uploadedFile
        );
        $file = new \Flow\File($config, $flowRequest);


        if ($request->getMethod() === 'GET') {
            if ($file->checkChunk()) {
                new JsonResponse(200);
            } else {
                new JsonResponse(204);

                return ;
            }
        } else {
            if ($file->validateChunk()) {
                rename($uploadedFile['tmp_name'], $file->getChunkPath($flowRequest->getCurrentChunkNumber()));
//                $file->saveChunk();
            } else {
                // error, invalid chunk upload request, retry
                new JsonResponse(400);

                return ;
            }
        }

        if ($file->validateFile() && $file->save($uploadDir . '/'. $uploadedFile['name'])) {
            // File upload was completed
        } else {
            // This is not a final chunk, continue to upload
        }
    }


}
