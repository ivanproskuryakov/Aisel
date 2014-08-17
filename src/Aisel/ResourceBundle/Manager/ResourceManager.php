<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Manager;

/**
 * Global manager for resources
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ResourceManager
{
    protected $sc;
    protected $em;

    /**
     * {@inheritdoc}
     */
    public function __construct($sc, $em)
    {
        $this->sc = $sc;
        $this->em = $em;
    }

}
