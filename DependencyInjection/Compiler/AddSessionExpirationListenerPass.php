<?php

/*
 * This file is part of the AJGL packages
 *
 * Copyright (C) Antonio J. García Lagar <aj@garcialagar.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ajgl\Bundle\SessionExpirationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Antonio J. García Lagar <aj@garcialagar.es>
 */
class AddSessionExpirationListenerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->getParameter('ajgl.security.authentication.session_expiration_firewalls') as $firewall) {
            $definition = $container->findDefinition('security.firewall.map.context.' . $firewall);
            $listeners = $definition->getArgument(0);
            $listeners[] = new Reference('ajgl.security.authentication.session_expiration_listener.' . $firewall);
            $definition->replaceArgument(0, $listeners);
        }
    }
}
