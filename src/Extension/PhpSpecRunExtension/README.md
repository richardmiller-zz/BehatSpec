PhpSpecRunExtension
===================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/richardmiller/PhpSpecRunExtension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/PhpSpecRunExtension/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/richardmiller/PhpSpecRunExtension/badges/build.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/PhpSpecRunExtension/build-status/master)

**Note!** This is **READ-ONLY** repository. Any PRs should be based on and sent
to [BehatSpec repository](https://github.com/richardmiller/BehatSpec).

[PhpSpec](http://www.phpspec.net/en/stable) extension that adds support of
automatically running `phpspec run` command right after `phpsec describe`.

Installation
------------

This extension requires:

* PhpSpec 3.0+
* PHP 5.6+

The easiest way to install it is to use Composer

```
$ composer require --dev rmiller/phpspec-run-extension
```

Activate the extension by editing `phpspec.yml` of your project:

```yaml
# phpspec.yml
extensions:
    RMiller\BehatSpec\Extension\PhpSpecRunExtension\PhpSpecRunExtension: ~
```

By default this extension will try to use `bin/phpspec` for executing `phpspec`
commands. This can be overridden when enabling extension in `phpspec.yml`:

```yaml
# phpspec.yml
# ..
    extensions:
        RMiller\BehatSpec\Extension\PhpSpecRunExtension\PhpSpecRunExtension: ~
            path: vendor/bin/phpspec                    # path to phpspec bin
            commands: [describe, exemplify, other_cmd]  # commands
            config: path/to/phpspec.yml                 # custom phpspec.yml path
```

This will now also execute the run command after the exemplify command added by
the [ExemplifyExtension](https://github.com/richardmiller/ExemplifyExtension).

## Similar Extensions

* [PhpSpecExtension][10] - executes `phpspec describe` command automatically
  for classes that are missing in `behat` ([Behat][1] extension).
* [ErrorExtension][11] - provides formatted error messages for `behat`. This is
  used by [PhpSpecRunExtension][20] to trigger `phpspec describe` ([Behat][1]
  extension).
* [ExemplifyExtension][21] - adds `phpspec exemplify` command for generating
  examples in specs ([PhpSpec][2] extension).
- [BehatSpec][3] is a collection of extensions that offer integration
  between latest stable [Behat][1] and [PhpSpec][2].

[1]: http://docs.behat.org/en/stable
[2]: http://phpspec.net/en/stable
[3]: https://github.com/richardmiller/BehatSpec
[10]: https://github.com/richardmiller/PhpSpecExtension
[11]: https://github.com/richardmiller/ErrorExtension
[20]: https://github.com/richardmiller/PhpSpecRunExtension
[21]: https://github.com/richardmiller/ExemplifyExtension

