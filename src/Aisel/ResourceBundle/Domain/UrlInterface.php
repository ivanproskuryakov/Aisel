<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Domain;

/**
 * UrlInterface
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
interface UrlInterface
{

    /**
     * Set metaUrl
     *
     * @param string $metaUrl
     */
    public function setMetaUrl($metaUrl);

    /**
     * Get metaUrl
     *
     * @return string
     */
    public function getMetaUrl();

}
