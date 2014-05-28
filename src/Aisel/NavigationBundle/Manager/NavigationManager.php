<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Manager;

/**
 * Manager for Navigation
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class NavigationManager
{
    protected $sc;
    protected $em;

    public function __construct($sc, $em)
    {
        $this->sc = $sc;
        $this->em = $em;
    }

    /**
     * Returns enabled menu
     *
     * @return object
     */
    public function getMenu()
    {
        $menu = $this->em->getRepository('AiselNavigationBundle:Menu')->getEnabledMenuItems();
        return $menu;
    }


}
