# BehatSpec

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/richardmiller/BehatSpec/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/BehatSpec/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/richardmiller/BehatSpec/badges/build.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/BehatSpec/build-status/master)

[BehatSpec][0] is a collection of extenstions that offer integration
between latest stable [Behat][1] and [PhpSpec][2]:

* Creates specs for any missing classes encountered when running behat
* Adds examples for any missing methods encountered when running behat
* Executes the phpspec run command after this to add the described class/method

This integration is done by the extensions that can also be used standalone:

* [PhpSpecExtension][10] - executes `phpspec describe` command automatically
  for classes that are missing in `behat` ([Behat][1] extension).
* [ErrorExtension][11] - provides formatted error messages for `behat`. This is
  used by [PhpSpecRunExtension][20] to trigger `phpspec describe` ([Behat][1]
  extension).
* [PhpSpecRunExtension][20] - executes `phpspec run` after `describe`
  ([PhpSpec][2] extension).
* [ExemplifyExtension][21] - adds `phpspec exemplify` command for generating
  examples in specs ([PhpSpec][2] extension).

However, if you install [BehatSpec][0] package extension, it will provide all
the integrated extensions from a single package.

## Why

This is useful when rather than using the Behat context to run an application
through its UI, it is instead used to implement the domain model. For more
information on this way of using Gherkin features to drive domain modelling
read Everzet's post on [Modelling by
Example](http://everzet.com/post/99045129766/introducing-modelling-by-example)

When running a feature with a Context that contains a new class that does not
exist or a method you will get a fatal error. If using PhpSpec the next step
would be to start specifying that class using the describe command. This set of
extensions provides integration between Behat and PhpSpec so that instead of
a fatal error you can choose to run the describe command for the missing class
automatically.

It also uses [ExemplifyExtension][21] so that you can automatically add
examples for missing methods in a similar way.

After describing a class or method in this way the `phpspec run` command can
be used to automatically create the class or model. Since this is the typical
next step in most cases, this extension automates that by asking you if you
would like to do that next.

### An Example

So to use an example from the blog post linked above:

```
/**
 * @Given a product named :name and priced £:price was added to the catalogue
 */
public function aProductNamedAndPricedWasAddedToTheCatalogue($name, Money $price)
{
    $aProduct = Product::namedAndPriced($name, $price);
    $this->catalogue->add($aProduct);
}
```

Running the feature relating to this context would result in a fatal exception
normally. Instead you get a simple error and the offer to create a spec for the
missing class:

![Product not found](/docs/images/error.png?raw=true)

The spec is created followed by an offer to run `phpspec run`:

![Spec created](/docs/images/spec-created.png?raw=true)

Which asks to create the class:

![Created Product?](/docs/images/create.png?raw=true)

![Product created](/docs/images/product-created.png?raw=true)

Running Behat again will result in a similar process for the `namedAndPriced`
method. Where an example for the method will be added to the spec and the
method added to the class.

## How

### Requirements

* Behat 3.0+
* PhpSpec 3.0+
* PHP 5.6+

**Note!** In order to use `BehatSpec` with PHPSpec 2.0 series and PHP 5.4, use
`0.3.*` version series and check [install instructions for 0.3.* version][3].

### Installation

Install this package as a development requirement in your project:

```
$ composer require --dev rmiller/behat-spec
```

### Configuration

Activate the [Behat][1] extensions in `behat.yml` of your project:

```yaml
# behat.yml
# ...
default:
    # ...
    extensions:
        RMiller\BehatSpec\Extension\BehatSpecExtension\BehatExtension:
            path:  bin/phpspec #default value is bin/phpspec
            config:  path/to/phpspec.yml #optional
```

**Note!** The configuration example above will also make sure that
[PhpSpecExtension][10] and [ErrorExtension][11] are enabled in [Behat][1].
You do NOT need to enable these specific extensions manually.

Next, Activate the [PhpSpec][2] extensions in `phpspec.yml` of your project:

```yaml
# phpspec.yml
extensions:
    RMiller\BehatSpec\Extension\BehatSpecExtension\PhpSpecExtension: ~
    # The below part is only needed if you want to customize the defaults
    RMiller\BehatSpec\Extension\PhpSpecRunExtension\PhpSpecRunExtension:
        path: bin/phpspec
        commands: [describe, exemplify, your_own_fancy_command]
        config: phpspec.yml
```

**Note!** The configuration example above will also make sure that
[PhpSpecRunExtension][20] and [ExemplifyExtension][21] are enabled in
[PhpSpec][2]. You do NOT need to enable these specific extensions manually.

Please refer to [Why](#Why) section for usage information.

[0]: https://github.com/richardmiller/BehatSpec
[1]: http://docs.behat.org/en/stable
[2]: http://phpspec.net/en/stable
[3]: https://github.com/richardmiller/BehatSpec/tree/phpspec2-support
[10]: https://github.com/richardmiller/PhpSpecExtension
[11]: https://github.com/richardmiller/ErrorExtension
[20]: https://github.com/richardmiller/PhpSpecRunExtension
[21]: https://github.com/richardmiller/ExemplifyExtension

