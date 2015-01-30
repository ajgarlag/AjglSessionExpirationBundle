<?php

/*
 * This file is part of the AJGL packages
 *
 * Copyright (C) Antonio J. García Lagar <aj@garcialagar.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ajgl\Bundle\SessionExpirationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Antonio J. García Lagar <aj@garcialagar.es>
 */
class AjglSessionExpirationExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (isset($config['firewalls'])) {
            $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
            $loader->load('security_listener.xml');

            $firewalls = array();

            foreach ($config['firewalls'] as $name => $sessionExpirationConfig) {
                $sessionExpirationListenerId = 'ajgl.security.authentication.session_expiration_listener.'.$name;
                $listener = $container->setDefinition($sessionExpirationListenerId, new DefinitionDecorator('ajgl.security.authentication.session_expiration_listener'));
                $listener->replaceArgument(2, $sessionExpirationConfig['max_idle_time']);
                $listener->replaceArgument(3, $sessionExpirationConfig['expiration_url']);

                $firewalls[] = $name;
            }

            $container->setParameter('ajgl.security.authentication.session_expiration_firewalls', $firewalls);
        }
    }
}
