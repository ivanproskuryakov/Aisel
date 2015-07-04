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
        $uploadDir = $this->container->getParameter('application.media.product.upload_dir');

        $config = new \Flow\Config();
        $config->setTempDir($uploadDir);
        $file = new \Flow\File($config);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($file->checkChunk()) {
                header("HTTP/1.1 200 Ok");
            } else {
                header("HTTP/1.1 204 No Content");
                return ;
            }
        } else {
            if ($file->validateChunk()) {
                $file->saveChunk();
            } else {
                // error, invalid chunk upload request, retry
                header("HTTP/1.1 400 Bad Request");
                return ;
            }
        }
        if ($file->validateFile() && $file->save('./final_file_name')) {
            // File upload was completed
        } else {
            // This is not a final chunk, continue to upload
        }
    }


}
