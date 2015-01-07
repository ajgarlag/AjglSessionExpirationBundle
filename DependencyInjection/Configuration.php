<?php

/*
 * This file is part of the AJ General Libraries Bundles
 *
 * Copyright (C) 2010-2014 Antonio J. García Lagar <aj@garcialagar.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ajgl\Bundle\SessionExpirationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Antonio J. García Lagar <aj@garcialagar.es>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ajgl_session_expiration');

        $rootNode
            ->children()
                ->arrayNode('firewalls')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->integerNode('max_idle_time')->defaultValue(ini_get('session.gc_maxlifetime'))->min(1)->end()
                            ->scalarNode('expiration_url')->defaultNull()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
