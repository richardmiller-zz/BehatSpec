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


1. Require the extension:

    .. code-block:: bash

        $ composer require --dev rmiller/behat-spec:~0.1

2. Activate the Behat extension by specifying its class in your ``behat.yml``:

   .. code-block:: yaml

       # behat.yml
       default:
         # ...
         extensions:
           RMiller\BehatSpec\BehatExtension: ~:
             path:  bin/phpspec #default value is bin/phpspec

3. Activate the PhpSpec extension by specifying its class in your ``phpspec.yml``:

   .. code-block:: yaml

       # phpspec.yml
       extensions:
         - RMiller\BehatSpec\PhpSpecExtension

Still to Come
~~~~~~~~~~~~~

* Executing the phpspec run command automatically after creating specs and adding examples
* Other things, any ideas?
