<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * ApiController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiController extends Controller
{

    /**
     * menuAction
     *
     * @param string $locale
     *
     * @return mixed $menu
     */
    public function getAction($locale)
    {
        $menu = $this
            ->container
            ->get("aisel.navigation.node.manager")
            ->getNodesTree($locale);

        return $menu;
    }

}
