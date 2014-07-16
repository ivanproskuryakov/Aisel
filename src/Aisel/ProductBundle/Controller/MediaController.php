<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Aisel\ResourceBundle\Uploader\UploadHandler;

/**
 * Frontend Product REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class MediaController extends Controller
{

    public function uploadAction(){

        $serverUrl = '/mediauploader/';
        $fullPath = dirname(__DIR__);
        $productDir = '/media/product';

        $options = array(
            'script_url' => $serverUrl,
            'upload_dir' => $fullPath . $productDir . '/1/',
            'upload_url' => $productDir . '/1/',
        );


        $upload_handler = new UploadHandler($options);
        exit();
    }
}
