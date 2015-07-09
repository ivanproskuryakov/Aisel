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
use Flow\Request as FlowRequest;
use Flow\Config as FlowConfig;
use Flow\File as FlowFile;
use Aisel\ProductBundle\Entity\Image;
use Aisel\ResourceBundle\Controller\ApiController as BaseApiController;

/**
 * ApiImageController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiImageController extends BaseApiController
{
    /**
     * @var string
     */
    protected $model = "Aisel\ProductBundle\Entity\Image";

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
                new JsonResponse(200);
            } else {
                new JsonResponse(204);

                return ;
            }
        } else {
            if ($flowFile->validateChunk()) {
                rename($uploadedFile['tmp_name'], $flowFile->getChunkPath($flowRequest->getCurrentChunkNumber()));
            } else {
                new JsonResponse(400);

                return ;
            }
        }

        if ($flowFile->validateFile() && $flowFile->save($uploadDir . '/'. $uploadedFile['name'])) {

            // Product images
            $em = $this->get('doctrine.orm.entity_manager');
            $product = $em
                ->getRepository('Aisel\ProductBundle\Entity\Product')
                ->find($id);
            $fileUrl = '/'. $product->getId() .'/'. $uploadedFile['name'];

            $image = new Image();
            $image->setFilename($fileUrl);
            $image->setProduct($product);
            $image->setMainImage(true);
            $em->persist($image);
            $em->flush();

        } else {
            // This is not a final chunk, continue to upload
        }
    }


}
