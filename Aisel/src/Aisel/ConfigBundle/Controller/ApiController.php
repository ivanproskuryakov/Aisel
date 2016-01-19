<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * ApiController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiController extends Controller
{

    /**
     * Config for frontend
     *
     * @param string $locale
     *
     * @return array $config
     */
    public function getAction($locale)
    {
        $config = $this
            ->container
            ->get("aisel.config.manager")
            ->getConfigFrontend($locale);

        return $config;
    }

}
