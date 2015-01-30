<?php

/*
 * This file is part of the AJGL packages
 *
 * Copyright (C) Antonio J. García Lagar <aj@garcialagar.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ajgl\Bundle\SessionExpirationBundle\Tests\Functional;

/**
 * @author Antonio J. García Lagar <aj@garcialagar.es>
 */
class SessionExpirationTest extends WebTestCase
{

    public function testExpiredExceptionRedirectsToTargetUrl()
    {
        $client = $this->createClient(array('test_case' => 'SessionExpiration', 'root_config' => 'config.yml'));
        $form = $client->request('GET', '/login')->selectButton('login')->form();
        $form['_username'] = 'antonio';
        $form['_password'] = 'secret';
        $client->submit($form);
        $this->assertRedirect($client->getResponse(), '/profile');

        $client->request('GET', '/protected_resource');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        sleep(2); //Wait for session to expire
        $client->request('GET', '/protected_resource');
        $this->assertRedirect($client->getResponse(), '/expired');
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->deleteTmpDir('SessionExpiration');
    }
}
