# BehatSpec


## What


Integration between [Behat](http://docs.behat.org/en/v3.0/) and
[PhpSpec](http://phpspec.net/).

* Creates specs for any missing classes encountered when running behat
* Adds examples for any missing methods encountered when running behat
* Executes the phpspec run command after this to add the described class/method

## Why

This is useful when rather than using the Behat context to run an application
through its UI, it is instead used to implement the domain model. For more
information on this way of using Gherkin features to drive domain modelling
read Everzet's post on [Modelling by Example](http://everzet.com/post/99045129766/introducing-modelling-by-example)

When running a feature with a Context that contains a new class that does not exist
or a method you will get a fatal error. If using PhpSpec the next step would be to
start specifying that class using the describe command. This set of extensions provides
integration between Behat and PhpSpec so that instead of a fatal error you can
choose to run the describe command for the missing class automatically.

It also uses my [ExemplifyExtension](https://github.com/richardmiller/ExemplifyExtension)
so that you can automatically add examples for missing methods in a similar way.

After describing a class or method in this way the `phpspec run` command can
be used to automatically create the class or model. Since this is the typical
next step in most cases, this extension automates that by asking you if you would
like to do that next.

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

Running the feature relating to this context would result in a fatal exception normally.
Instead you get a simple error and the offer to create a spec for the missing class:

![Product not found](/docs/images/error.png?raw=true)

The spec is created followed by an offer to run `phpspec run`:

![Spec created](/docs/images/spec-created.png?raw=true)

Which asks to create the class:

![Created Product?](/docs/images/create.png?raw=true)

![Product created](/docs/images/product-created.png?raw=true)

Running Behat again will result in a similar process for the `namedAndPriced` method.
Where an example for the method will be added to the spec and the method added
to the class.

## How

### Installation

This package provides an extension for PhpSpec and an extension for Behat. Both need
to be enabled for the full functionality.


Requires:

* Behat 3.0+
* PhpSpec 2.0+
* PHP 5.4+

Require the extension:

```
$ composer require --dev rmiller/behat-spec:~0.2
```

To get the phpspec run command running, you need to use latest phpspec 2.1@dev.
Otherwise that functionality will silently fail.

### Configuration

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

Additional configuration can be provided for the running of the `phpspec run` command:

It defaults to `bin/phpspec` for the path of phpspec and to run after the describe command.
These can be overridden as follows:

```yaml
# phpspec.yml
default:
  # ...
  extensions:
    - RMiller\BehatSpec\PhpSpecExtension
  rerunner:
    path: vendor/bin/phpspec
    commands: [describe, exemplify, your_own_fancy_command]
```

### Some Details

This package pulls together some other PhpSpec and Behat extensions which can also be used
standalone:

#### PhpSpec

* [PhpSpecRunExtension](https://github.com/richardmiller/PhpSpecRunExtension)
* [ExemplifyExtension](https://github.com/richardmiller/ExemplifyExtension)

#### Behat

* [PhpSpecExtension](https://github.com/richardmiller/PhpSpecExtension)
* [ErrorExtension](https://github.com/richardmiller/ErrorExtension)
