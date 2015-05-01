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

/**
 * Contact REST API for Frontend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiController extends Controller
{

    /**
     * sendAction
     *
     * @param Request $request
     *
     * @return array $status;
     */
    public function sendAction(Request $request)
    {
        $params = array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'message' => $request->get('message'),
        );

        if ($params['name'] && $params['name'] && $params['name'] && $params['name']) {
            $response = $this->container->get("aisel.contact.manager")->sendMail($params);

            if ($response == 1) {
                $status = array('status' => true, 'message' => 'Your message has been sent!');
            } else {
                $status = array('status' => false, 'message' => $response);
            }
        } else {
            $status = array('status' => false, 'message' => 'Empty params in your request');
        }

        return $status;

    }

}
