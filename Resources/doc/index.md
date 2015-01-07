AjglSessionExpirationBundle
===========================

Symfony bundle to block idle sessions


Instalation
-----------

###Download AjglSessionExpirationBundle

Add AjglSessionExpirationBundle in your composer.json:

```js
{
    "require": {
        "ajgl/session-expiration-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update ajgl/session-expiration-bundle
```

Composer will install the bundle to your project's `vendor/ajgl` directory.


###Enable the Bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Ajgl\Bundle\SessionExpirationBundle\AjglSessionExpirationBundle(),
    );
}
```


Configuration
-------------

To configure the session expiration, you have to define the max_idle_time and/or
the expiration URL for the firewalls where you want to have expire idle sessions.

``` yaml
# app/config/config.yml
ajgl_session_expiration:
    firewalls:
        firewall_name:
            max_idle_time: 1440
            expiration_url: /expired
```
