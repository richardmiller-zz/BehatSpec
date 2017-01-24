PhpSpecRunExtension
===================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/richardmiller/PhpSpecRunExtension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/PhpSpecRunExtension/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/richardmiller/PhpSpecRunExtension/badges/build.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/PhpSpecRunExtension/build-status/master)

PhpSpec extension that adds running run command after describe command

Installation
------------

This extension requires:

* PhpSpec 2.1+
* PHP 5.4+

It will only work with latest PhpSpec 2.1 which is not yet a stable release
as it relies on console events that were only recently added. In order to
be able to include this in [BehatSpec](https://github.com/richardmiller/BehatSpec) without forcing that to need 2.1 for the
time being you need to force the PhpSpec version and not rely on this extension's
dependencies


The easiest way to install it is to use Composer

```
$ composer require --dev rmiller/phpspec-run-extension:^0.4
```

Activate the extension by specifying its class in your ``phpspec.yml``:

```yaml
# phpspec.yml
default:
  # ...
  extensions:
    - RMiller\PhpSpecRunExtension\PhpSpecRunExtension
```

It defaults to `bin/phpspec` for the path of phpspec and to run after the describe command.
These can be overridden as follows:

```yaml
# phpspec.yml
default:
  # ...
  extensions:
    -RMiller\PhpSpecRunExtension\PhpSpecRunExtension
  rerunner:
    path: vendor/bin/phpspec
    commands: [describe, exemplify]
    config: path/to/phpspec.yml #optional
```

This will now also execute the run command after the exemplify command added by the
[ExemplifyExtension](https://github.com/richardmiller/ExemplifyExtension).
