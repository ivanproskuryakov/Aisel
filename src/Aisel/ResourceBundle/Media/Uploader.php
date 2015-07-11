<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Media;

use Symfony\Component\HttpFoundation\Request;
use Flow\Request as FlowRequest;
use Flow\Config as FlowConfig;
use Flow\File as FlowFile;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Uploader
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class Uploader
{

    /**
     * uploadAction
     *
     * @param string $uploadDir
     * @param Request $request
     * @throws HttpException
     *
     * @return string $filename
     */
    static public function uploadFile($uploadDir, $request) {
        $result = [];

        $config = new FlowConfig();
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

        $flowRequest = new FlowRequest(
            $uploadedRequest,
            $uploadedFile
        );
        $flowFile = new FlowFile($config, $flowRequest);

        if ($request->getMethod() === 'GET') {

            if ($flowFile->checkChunk()) {
                $result['status'] = true;
            } else {
                $result['status'] = false;
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

        if ($flowFile->validateFile() && $flowFile->save($uploadDir . '/'. $uploadedFile['name'])) {
            $result['status'] = true;
            $result['file'] = $uploadDir . '/'. $uploadedFile['name'];;
        } else {
            // This is not a final chunk, continue to upload
        }

        return $result;
    }

}
