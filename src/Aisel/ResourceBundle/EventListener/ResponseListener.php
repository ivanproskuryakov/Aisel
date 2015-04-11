<?php

namespace Aisel\ResourceBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ResponseListener
{

    private $backendAddress;
    private $frontendAddress;

    /**
     * Constructor
     *
     * @param $websiteAddress string
     * @param $backendAddress string
     * @param $frontendApi string
     * @param $backendApi string
     *
     */
    public function __construct(
        $websiteAddress,
        $backendAddress,
        $frontendApi,
        $backendApi
    )
    {
        $this->frontendAddress = $websiteAddress;
        $this->backendAddress = $backendAddress;
        $this->frontendApi = "/" . $frontendApi . "/";
        $this->backendApi = "/" . $backendApi . "/";
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->getRequestFormat() != 'json') {
            return;
        }

        // If its frontend
        if (strpos($request->getRequestUri(), $this->frontendApi) > -1) {
            $allowOrigin = $this->frontendAddress;
        }
        // In case of backend
        if (strpos($request->getRequestUri(), $this->backendApi) > -1) {
            $allowOrigin = $this->backendAddress;
        }
        $headers = $event
            ->getResponse()
            ->headers;

        $headers->set('Access-Control-Allow-Credentials', 'true');
        $headers->set('Access-Control-Allow-Origin', $allowOrigin);
        $headers->set('Access-Control-Allow-Headers', 'origin, x-requested-with, content-type');
        $headers->set('Access-Control-Allow-Methods', 'PUT, GET, HEAD, POST, DELETE, OPTIONS');
    }
}