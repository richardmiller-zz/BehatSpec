PhpSpecRunExtension
===================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/richardmiller/PhpSpecRunExtension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/PhpSpecRunExtension/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/richardmiller/PhpSpecRunExtension/badges/build.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/PhpSpecRunExtension/build-status/master)

PhpSpec extension that adds running run command after describe command

Installation
------------

This extension requires:

* PhpSpec 3.0+
* PHP 5.4+

The easiest way to install it is to use Composer

```
$ composer require --dev rmiller/phpspec-run-extension:^0.5
```

Activate the extension by specifying its class in your ``phpspec.yml``:

```yaml
# phpspec.yml
extensions:
  RMiller\BehatSpec\Extension\PhpSpecRunExtension\PhpSpecRunExtension: ~
```

It defaults to `bin/phpspec` for the path of phpspec and to run after the describe command.
These can be overridden as follows:

```yaml
# phpspec.yml
extensions:
  RMiller\BehatSpec\Extension\PhpSpecRunExtension\PhpSpecRunExtension: ~
rerunner:
  path: vendor/bin/phpspec
  commands: [describe, exemplify]
  config: path/to/phpspec.yml #optional
```

This will now also execute the run command after the exemplify command added by the
[ExemplifyExtension](https://github.com/richardmiller/ExemplifyExtension).
