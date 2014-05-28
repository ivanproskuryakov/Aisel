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

use FOS\RestBundle\Controller\Annotations as Rest;
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
     * @Rest\View
     * /api/contact/send.json
     */
    public function sendAction(Request $request)
    {
        $params = array(
            'name'=>$request->query->get('name'),
            'email'=>$request->query->get('email'),
            'phone'=>$request->query->get('phone'),
            'message'=>$request->query->get('message'),
        );

        $response = $this->container->get("aisel.contact.manager")->sendMail($params);

        // Set default error message, if something went wrong;
        $status = array('message'=>'Someting went wrong, please get in contact with us directly!');
        if ($response == 1) {
            $status = array('status'=>true,'message'=>'Your message has been sent!');
        } else {
            $status = array('message'=>$response);
        }

        return $status;

    }

}
