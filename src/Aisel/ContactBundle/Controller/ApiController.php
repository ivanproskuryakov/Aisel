<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;


/**
 * ApiController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiController extends Controller
{

    /**
     * sendMessageAction
     *
     * @param Request $request
     *
     * @return array $status;
     */
    public function sendMessageAction(Request $request)
    {
        $params = json_decode($request->getContent(), true);
        $this->container->get("aisel.contact.manager")->sendMail($params);

        return new Response();
    }

}
