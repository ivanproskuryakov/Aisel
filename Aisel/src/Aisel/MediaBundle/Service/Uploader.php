<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\MediaBundle\Service;

use Flow\Config as FlowConfig;
use Flow\File as FlowFile;
use Flow\Request as FlowRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Uploader
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class Uploader
{
    /**
     * uploadFile
     *
     * @param  string $mediaDir
     * @param  Request $request
     * @throws HttpException
     *
     * @return string
     */
    public static function uploadFile($mediaDir, Request $request)
    {
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

        $config = new FlowConfig();
        $config->setTempDir($mediaDir);
        $flowRequest = new FlowRequest(
            $request->request->all(),
            $uploadedFile
        );
        $flowFile = new FlowFile($config, $flowRequest);

        if ($request->getMethod() === 'GET') {
            $response = new Response();

            if ($flowFile->checkChunk()) {
                $response->setStatusCode(Response::HTTP_OK);
                $response->send();
            } else {
                $response->setStatusCode(Response::HTTP_NO_CONTENT);
                $response->send();
                return false;
            }
        } else {
            if ($flowFile->validateChunk()) {
                rename(
                    $uploadedFile['tmp_name'],
                    $flowFile->getChunkPath($flowRequest->getCurrentChunkNumber())
                );

            } else {
                throw new HttpException(400);
            }
        }
        $filename = $mediaDir . '/' . $uploadedFile['name'];

        if ($flowFile->validateFile() && $flowFile->save($filename)) {
            return $filename;
        } else {
            // This is not a final chunk, continue to upload
        }

        return false;
    }

}
