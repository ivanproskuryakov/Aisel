<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ConfigBundle\Routing;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Dynamic router
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ExtraLoader implements LoaderInterface
{
    private $loaded = false;
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add this loader twice');
        }

        $configEntities = $this->container->getParameter('aisel_config.entities');
        $prefix = $this->container->getParameter('aisel_config.route_prefix');

        $routes = new RouteCollection();

        foreach ($configEntities as $name => $entity) {

            $_contoller = $entity['controller'];
            $defaults = array(
                '_controller' => $_contoller,
            );

            $route = new Route($name, $defaults);
            $routes->add($prefix . $name, $route);
        }

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return 'extra' === $type;
    }

    public function getResolver()
    {
    }

    public function setResolver(LoaderResolverInterface $resolver)
    {
        // irrelevant to us, since we don't need a resolver
    }
}
