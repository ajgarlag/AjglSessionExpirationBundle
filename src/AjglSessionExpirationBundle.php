<?php

/*
 * This file is part of the AJGL packages
 *
 * Copyright (C) Antonio J. García Lagar <aj@garcialagar.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ajgl\Bundle\SessionExpirationBundle;

use Ajgl\Bundle\SessionExpirationBundle\DependencyInjection\Compiler\AddSessionExpirationListenerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Antonio J. García Lagar <aj@garcialagar.es>
 */
class AjglSessionExpirationBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        if (!$container->hasExtension('security')) {
            throw new \LogicException('The AjglSessionExpirationBundle must be registered after the SecurityBundle in your AppKernel.php.');
        }

        $container->addCompilerPass(new AddSessionExpirationListenerPass());

        parent::build($container);
    }
}
