ErrorExtension
==============

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/richardmiller/ErrorExtension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/ErrorExtension/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/richardmiller/ErrorExtension/badges/build.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/ErrorExtension/build-status/master)

[Behat](http://docs.behat.org/en/v3.0/) extension to provide formatted error messages for fatal errors.

This stops the large stack traces appearing on every fatal error. Instead a simpler
formatted error showing the error message, file and line number is shown.
If you need the full stack trace then they will still appear when Behat
is run with the verbose flag.

Since this does work in the shutdown function there is a good chance things
will go horribly wrong if there are any errors/exceptions in handing the errors.
It's an extension to a dev tool though so this is not that worth worrying about.

Installation
------------

This extension requires:

* Behat 3.0+
* PHP 5.4+

The easiest way to install it is to use Composer

```
$ composer require --dev rmiller/error-extension:^0.5
```

Activate the extension by specifying its class in your ``behat.yml``:

```yaml
# behat.yml
default:
  # ...
  extensions:
    RMiller\BehatSpec\Extension\ErrorExtension\ErrorExtension: ~
```

Error Observers
---------------

Observers can be registered for the errors to handle them in some way from
another Behat extension. Observers must implement
`RMiller\BehatSpec\Extensions\ErrorExtensions\Observer\ErrorObserverInterface`
and be tagged with `rmiller.error_listener` tag in the service configuration.

Example of a custom error observer:

```php
use RMiller\BehatSpec\Extension\ErrorExtension\Observer\ErrorObserverInterface;

class CustomErrorObserver implements ErrorObserverInterface
{
    public function notify(array $error) {
        // observer notify method implementation
    }
}
```

Currently this is used by the [PhpSpecExtension](https://github.com/richardmiller/PhpSpecExtension)
to trigger running PhpSpec commands on relevant errors.

