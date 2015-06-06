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

/**
 * Media Manager for Products
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class MediaManager
{
    protected $em;
    protected $appMediaProductPath;
    protected $websiteAddress;

    /**
     * {@inheritDoc}
     */
    public function __construct($em, $appMediaProductPath, $websiteAddress)
    {
        $this->em = $em;
        $this->appMediaProductPath = $appMediaProductPath;
        $this->websiteAddress = $websiteAddress;
    }

}
