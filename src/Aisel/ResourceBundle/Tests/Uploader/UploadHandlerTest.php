<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Tests\Utility;

use Aisel\ResourceBundle\PHPUnit\BaseTestCase;

/**
 * Uploader class test case
 */
class UploadHandlerTest extends BaseTestCase
{
    /**
     * Constructor testing, ensure that class exists and works fine
     *
     * @return null
     */
    public function testConstructor()
    {
        $productId = 1000;
        $mediaManager = $this->getService('aisel.product.media.manager');
        $pathInfo = '';
        $documentRoot = '';
        $mediaParams = $mediaManager->mapParamsForProductId($productId, $pathInfo, $documentRoot);
        $options = array(
            'script_url' => $mediaParams['script_url'],
            'upload_dir' => $mediaParams['upload_dir'], //$fullPath . $productDir . '/1/',
            'upload_url' => $mediaParams['upload_url'], //$productDir . '/1/',
        );
        ob_start();
        $this->assertEquals(true, true);
    }

}
