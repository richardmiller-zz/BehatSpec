PhpSpecExtension
================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/richardmiller/PhpSpecExtension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/PhpSpecExtension/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/richardmiller/PhpSpecExtension/badges/build.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/PhpSpecExtension/build-status/master)

**Note!** This is **READ-ONLY** repository. Any PRs should be based on and sent
to [BehatSpec repository](https://github.com/richardmiller/BehatSpec).

[Behat](http://docs.behat.org/en/stable) extension to run `phpspec describe`
command automatically for missing classes in `behat` scenarios.

For more explanation and additional related functionality see
[BehatSpec](https://github.com/richardmiller/BehatSpec), which uses this
extension in combination with others to provide integration
between latest stable [Behat](http://docs.behat.org/en/stable) and
[PhpSpec](http://phpspec.net/en/stable).

If you do want to use this extension standalone, it requires:

* Behat 3.0+
* PHP 5.6+

The easiest way to install it is to use Composer:

```
$ composer require --dev rmiller/phpspec-extension
```

Activate the extension by editing `behat.yml` in your project:

```yaml
# behat.yml
default:
    # ...
    extensions:
        RMiller\BehatSpec\Extension\PhpSpecExtension\PhpSpecExtension:
            path:  bin/phpspec           # default value is bin/phpspec
            config:  path/to/phpspec.yml # optional
```
