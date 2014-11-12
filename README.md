BehatSpec
=========

Integration between Behat and PhpSpec.

* Creates specs for any missing classes encountered when running behat
* Adds examples for any missing methods encountered when running behat
* Executes the phpspec run command after this to add the described class/method

It provides an extension for PhpSpec and an extension for Behat. Both need
to be enabled for the full functionality.

Installation
------------

Requires:

* Behat 3.0+
* PhpSpec 2.0+
* PHP 5.4+

Require the extension:

```
$ composer require --dev rmiller/behat-spec:~0.1
```

To get the phpspec run command running, you need to use latest phpspec 2.1@dev.
Otherwise that functionality will silently fail.

Activate the Behat extension by specifying its class in your `behat.yml`:

```yaml
# behat.yml
default:
 # ...
 extensions:
   RMiller\BehatSpec\BehatExtension:
     path:  bin/phpspec #default value is bin/phpspec
```     

Activate the PhpSpec extension by specifying its class in your `phpspec.yml`:

```yaml
# phpspec.yml
extensions:
 - RMiller\BehatSpec\PhpSpecExtension
```

