ExemplifyExtension
==================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/richardmiller/ExemplifyExtension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/ExemplifyExtension/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/richardmiller/ExemplifyExtension/badges/build.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/ExemplifyExtension/build-status/master)

**Note!** This is **READ-ONLY** repository. Any PRs should be based on and sent
to [BehatSpec repository](https://github.com/richardmiller/BehatSpec).

[PhpSpec](http://www.phpspec.net/en/stable) extension that adds exemplify
command to generate examples in specs.

For example, running:

```
bin/phpspec exemplify RMiller/Badger dig
```

And choosing the default option of 'instance method', will add the following example
to the `spec/RMiller/BadgerSpec` class:

```
public function it_should_dig()
{
    $this->dig();
}
```

This can then be modified to describe the behaviour for the method.

## Installation

Requires:

* PhpSpec 3.0+
* PHP 5.6+

To use 'named constructor' examples , you need to use phpspec `>2.1`.
Otherwise the examples will be created but will not run.

Require the extension:

```
$ composer require --dev rmiller/exemplify-extension
```

## Configuration

Activate the extension by specifying its class in your `phpspec.yml`:

```yaml
# phpspec.yml
extensions:
    RMiller\BehatSpec\Extension\ExemplifyExtension\ExemplifyExtension: ~
```

## Method Types

Three different method types are supported, on running the command you will be
asked which type of method is being described. These are:

* Instance Method (e.g. `$this->dig()`)
* Static Method (e.g. `$this::dig()`)
* Named Constructor

The names constructor option is for static methods used to instantiate and return
an instance of the class. It is essentially another name for a factory method. This
is listed separately as the example created is different.

For example, running:

```
bin/phpspec exemplify RMiller/Badger withName
```

And choosing the option of 'named constructor', will add the following
to the spec/RMiller/BadgerSpec class:

```
public function it_should_be_constructed_through_with_name()
{
    $this->beConstructedThrough('withName');
}
```

## Similar Extensions

* [PhpSpecExtension][10] - executes `phpspec describe` command automatically
  for classes that are missing in `behat` ([Behat][1] extension).
* [ErrorExtension][11] - provides formatted error messages for `behat`. This is
  used by [PhpSpecRunExtension][20] to trigger `phpspec describe` ([Behat][1]
  extension).
- [PhpSpecRunExtension][20] - provides support of executing `phpspec run` commands automatically after `describe` (or `exemplify`) commands.
- [BehatSpec][3] is a collection of extensions that offer integration
  between latest stable [Behat][1] and [PhpSpec][2].


[1]: http://docs.behat.org/en/stable
[2]: http://phpspec.net/en/stable
[3]: https://github.com/richardmiller/BehatSpec
[10]: https://github.com/richardmiller/PhpSpecExtension
[11]: https://github.com/richardmiller/ErrorExtension
[20]: https://github.com/richardmiller/PhpSpecRunExtension
[21]: https://github.com/richardmiller/ExemplifyExtension

