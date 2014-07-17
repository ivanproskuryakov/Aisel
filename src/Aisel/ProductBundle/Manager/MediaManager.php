<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Manager;

use Aisel\ResourceBundle\Uploader\UploadHandler;

/**
 * Media Manager for Products
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class MediaManager
{
    protected $sc;
    protected $em;
    protected $appMediaProductPath;
    protected $websiteAddress;

    public function __construct($sc, $em, $appMediaProductPath, $websiteAddress)
    {
        $this->sc = $sc;
        $this->em = $em;
        $this->appMediaProductPath = $appMediaProductPath;
        $this->websiteAddress = $websiteAddress;

    }


    /**
     * Uploader for product with id $productId
     *
     * @var int $productId
     *
     * @return string
     */
    public function launchMediaUploaderForProductId($productId)
    {

        $mediaParams = $this->mapParamsForProductId($productId);
        $options = array(
            'script_url' => $mediaParams['script_url'],
            'upload_dir' => $mediaParams['upload_dir'], //$fullPath . $productDir . '/1/',
            'upload_url' => $mediaParams['upload_url'], //$productDir . '/1/',
        );

        /*
         * UploadHandler echos response directly in browser
         * we don't want to modify existing class so just
         * use ob_start and ob_get_contents
         */

        ob_start();
        $uploadHandler = new UploadHandler($options);
        $outputContents = stripslashes(ob_get_contents());
        ob_end_clean();
        $mediaFiles = json_decode($outputContents);
        foreach ($mediaFiles->files as $_file) {
            // @todo: finis savind to database
            //print_r($_file->name);
        }
        return $outputContents;
    }

    /**
     * Map product media URI and paths for product Id
     *
     * @var int $productId
     *
     * @return array $mediaParams
     */
    private function mapParamsForProductId($productId)
    {
        $productMedia = $this->appMediaProductPath . DIRECTORY_SEPARATOR . $productId . DIRECTORY_SEPARATOR;

        $media = array(
            'upload_url' => $this->websiteAddress . $productMedia,
            'script_url' => $this->websiteAddress . $this->sc->get('request')->getPathInfo(),
            'upload_dir' => realpath($this->sc->get('request')->server->get('DOCUMENT_ROOT')) . $productMedia,
        );

        return $media;
    }

}
