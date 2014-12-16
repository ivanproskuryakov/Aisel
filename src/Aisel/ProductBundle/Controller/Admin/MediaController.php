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

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frontend Product REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class MediaController extends Controller
{
    /**
     * /%website_admin%/product/media/{productId}/
     */
    public function uploadAction(Request $request, $productId)
    {

        $logger = $this->get('logger');
        $logger->info($request->get('files'));
        $pathInfo = $request->get('request')->getPathInfo();
        $documentRoot = realpath($this->sc->get('request')->server->get('DOCUMENT_ROOT'));
        $json = $this->container->get("aisel.product.media.manager")
            ->launchMediaUploaderForProductId($productId, $pathInfo, $documentRoot);

        return new Response($json);
    }
}
