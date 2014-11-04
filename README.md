BehatSpec
=========

Integration between Behat and PhpSpec.

* Creates specs for any missing classes encountered when running behat
* Adds examples for any missing methods encountered when running behat

It provides an extension for PhpSpec and an extension for Behat. Both need
to be enabled for the full functionality.

Installation
------------

Requires:

* Behat 3.0+
* PhpSpec 2.0+
* PHP 5.4+

Through Composer
~~~~~~~~~~~~~~~~

Require the extension:

```
$ composer require --dev rmiller/behat-spec:~0.1
```

Activate the Behat extension by specifying its class in your ``behat.yml``:

```yaml
# behat.yml
default:
 # ...
 extensions:
   RMiller\BehatSpec\BehatExtension: ~:
     path:  bin/phpspec #default value is bin/phpspec
```     

Activate the PhpSpec extension by specifying its class in your ``phpspec.yml``:

```yaml
# phpspec.yml
extensions:
 - RMiller\BehatSpec\PhpSpecExtension
```

Still to Come
~~~~~~~~~~~~~

* Executing the phpspec run command automatically after creating specs and adding examples
* Other things, any ideas?
