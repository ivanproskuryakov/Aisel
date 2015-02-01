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

use Aisel\NavigationBundle\Entity\Menu;

/**
 * Manager for Navigation
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class NavigationManager
{

    protected $em;

    /**
     * {@inheritDoc}
     */
    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Returns navigation menu for current locale
     *
     * @param string $locale
     *
     * @return object
     */
    public function getMenu($locale)
    {
        $menu = $this->em->getRepository('AiselNavigationBundle:Menu')->getEnabledMenuItems($locale);

        return $menu;
    }

}
