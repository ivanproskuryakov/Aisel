<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * ApiMediaController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiMediaController extends Controller
{
    /**
     * @param Request $request
     * @param $productId
     *
     * @return null
     */
    public function uploadAction(Request $request, $productId)
    {
        return null;
    }
}
