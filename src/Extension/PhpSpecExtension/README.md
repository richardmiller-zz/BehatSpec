PhpSpecExtension
================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/richardmiller/PhpSpecExtension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/PhpSpecExtension/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/richardmiller/PhpSpecExtension/badges/build.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/PhpSpecExtension/build-status/master)

Behat extension to run phpspec desc command automatically for missing classes.

For more explanation and additional related functionality see [BehatSpec](https://github.com/richardmiller/BehatSpec).
Which uses this extension in combination with others to provide integration
between [Behat](http://docs.behat.org/en/v3.0/) and [PhpSpec](http://phpspec.net/).


If you do want to use this extension standalone, it requires:

* Behat 3.0+
* PHP 5.6+


The easiest way to install it is to use Composer

```
$ composer require --dev rmiller/phpspec-extension:^0.5
```

Activate the extension by specifying its class in your ``behat.yml``:

```yaml
# behat.yml
default:
  # ...
  extensions:
    RMiller\BehatSpec\Extension\PhpSpecExtension\PhpSpecExtension:
      path:  bin/phpspec #default value is bin/phpspec
      config:  path/to/phpspec.yml #optional
```
