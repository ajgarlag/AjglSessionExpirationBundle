<?php

/*
 * This file is part of the AJGL packages
 *
 * Copyright (C) Antonio J. García Lagar <aj@garcialagar.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ajgl\Bundle\SessionExpirationBundle\Tests\DependencyInjection;

use Ajgl\Bundle\SessionExpirationBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\AbstractConfigurationTestCase;

class ConfigurationTest extends AbstractConfigurationTestCase
{
    protected function getConfiguration()
    {
        return new Configuration();
    }

    public function testFailedConfiguration()
    {
        $this->assertConfigurationIsInvalid(
            array(
                'ajgl_session_expiration' => array(
                    'firewalls' => array(
                        'default' => array(
                            'max_idle_time' => 0,
                        ),
                    ),
                ),
            )
        );

        $this->assertConfigurationIsInvalid(
            array(
                'ajgl_session_expiration' => array(
                    'firewalls' => array(
                        'default' => array(
                            'max_idle_time' => null,
                            'expiration_url' => '/lala',
                        ),
                    ),
                ),
            )
        );
    }

    public function testDefaultProcessedValues()
    {
        $this->assertProcessedConfigurationEquals(
            array(
                array(
                    'firewalls' => array(
                        'default' => array(),
                    ),
                ),
            ),
            array(
                'firewalls' => array(
                    'default' => array(
                        'max_idle_time' => ini_get('session.gc_maxlifetime'),
                        'expiration_url' => null,
                    ),
                ),
            )
        );
    }
}
