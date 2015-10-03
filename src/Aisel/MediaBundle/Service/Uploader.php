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

use Symfony\Component\HttpFoundation\Request;
use Flow\Request as FlowRequest;
use Flow\Config as FlowConfig;
use Flow\File as FlowFile;
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
            if ($flowFile->checkChunk()) {
                header("HTTP/1.1 200 Ok");
            } else {
                header("HTTP/1.1 204 No Content");

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

        if ($flowFile->validateFile() && $flowFile->save($mediaDir . '/' . $uploadedFile['name'])) {
            return $uploadedFile['name'];
        } else {
            // This is not a final chunk, continue to upload
        }

        return false;
    }

}
