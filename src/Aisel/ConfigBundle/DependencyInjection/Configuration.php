<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ConfigBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('aisel_config');
        $rootNode
            ->children()
            ->scalarNode('route_prefix')
            ->defaultValue('config_')
            ->end()
            ->scalarNode('settings_route')
            ->defaultValue('/administration/settings/{editLocale}/')
            ->end()
            ->arrayNode('entities')
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('name')
            ->prototype('array')
            ->children()
            ->scalarNode('order')->end()
            ->scalarNode('controller')->end()
            ->end();

        return $treeBuilder;
    }
}
