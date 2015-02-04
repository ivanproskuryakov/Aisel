<?php

namespace Aisel\ResourceBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ResponseListener
{

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->getRequestFormat() != 'json') {
            return;
        }

        if (strpos($request->getRequestUri(), '/api/') > -1) $allowOrigin = 'http://ecommerce.aisel.dev';
        if (strpos($request->getRequestUri(), '/admin/api/') > -1) $allowOrigin = 'http://admin.ecommerce.aisel.dev';

        $event->getResponse()->headers->set('Access-Control-Allow-Credentials', 'true');
        $event->getResponse()->headers->set('Access-Control-Allow-Origin', $allowOrigin);
        $event->getResponse()->headers->set('Access-Control-Allow-Headers', 'origin, x-requested-with, content-type');
        $event->getResponse()->headers->set('Access-Control-Allow-Methods', 'PUT, GET, POST, DELETE, OPTIONS');
    }
}