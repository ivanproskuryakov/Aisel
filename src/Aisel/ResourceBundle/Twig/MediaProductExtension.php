<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Twig;

class MediaProductExtension extends \Twig_Extension
{
    protected $sc;

    /**
     * {@inheritdoc}
     */
    public function __construct($sc)
    {
        $this->sc = $sc;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('mediaProductURI', array($this, 'mediaProductURI')),
        );
    }

    /**
     * Get product media directory
     * @param int $productId
     * @return string
     */
    public function mediaProductURI($productId)
    {
        $mediaProductURI = $this->sc->get('router')
            ->generate('admin_aisel_product_media_upload', array('productId' => $productId));
        return $mediaProductURI;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'media_product_extension';
    }
}