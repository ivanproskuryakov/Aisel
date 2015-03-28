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
            ->arrayNode('entities')->prototype('array')->children()
            ->scalarNode('order')->end()
            ->arrayNode('fields')->requiresAtLeastOneElement()->prototype('array')->children()
            ->scalarNode('type')->end()
            ->arrayNode('options')->requiresAtLeastOneElement()->prototype('scalar')->end()
            ->end();

        return $treeBuilder;
    }
}
