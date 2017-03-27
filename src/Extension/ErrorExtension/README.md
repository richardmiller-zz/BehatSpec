ErrorExtension
==============

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/richardmiller/ErrorExtension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/ErrorExtension/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/richardmiller/ErrorExtension/badges/build.png?b=master)](https://scrutinizer-ci.com/g/richardmiller/ErrorExtension/build-status/master)

**Note!** This is **READ-ONLY** repository. Any PRs should be based on and sent
to [BehatSpec repository](https://github.com/richardmiller/BehatSpec).

[Behat](http://docs.behat.org/en/stable/) extension to provide formatted error
messages for fatal errors.

This stops the large stack traces appearing on every fatal error. Instead a simpler
formatted error showing the error message, file and line number is shown.
If you need the full stack trace then they will still appear when Behat
is run with the verbose flag.

Since this does work in the shutdown function there is a good chance things
will go horribly wrong if there are any errors/exceptions in handing the errors.
It's an extension to a dev tool though so this is not that worth worrying about.

Installation
------------

This extension requires:

* Behat 3.0+
* PHP 5.6+

Install this extension as a development requirement in your project:

```
$ composer require --dev rmiller/error-extension
```

Activate the extension by specifying its class in your ``behat.yml``:

```yaml
# behat.yml
default:
    # ...
    extensions:
        RMiller\BehatSpec\Extension\ErrorExtension\ErrorExtension: ~
```

Error Observers
---------------

Observers can be registered for the errors to handle them in some way from
another Behat extension. All the observes must implement
`\RMiller\BehatSpec\Extension\ErrorExtension\Observer\ErrorObserver` interface
and be tagged with `rmiller.error_listener` tag in the service configuration.

An snippet of source code from the interface that you need to implement:

```php
namespace RMiller\BehatSpec\Extension\ErrorExtension\Observer;

interface ErrorObserver
{
    public function notify(array $error);
}
```

This extension is used by the
[PhpSpecExtension](https://github.com/richardmiller/PhpSpecExtension)
to trigger running PhpSpec commands on relevant errors.

## Similar Extensions

* [PhpSpecExtension][10] - executes `phpspec describe` command automatically
  for classes that are missing in `behat` ([Behat][1] extension).
* [ExemplifyExtension][21] - adds `phpspec exemplify` command for generating
  examples in specs ([PhpSpec][2] extension).
- [PhpSpecRunExtension][20] - provides support of executing `phpspec run` commands automatically after `describe` (or `exemplify`) commands.
- [BehatSpec][3] is a collection of extensions that offer integration
  between latest stable [Behat][1] and [PhpSpec][2].

[1]: http://docs.behat.org/en/stable
[2]: http://phpspec.net/en/stable
[3]: https://github.com/richardmiller/BehatSpec
[10]: https://github.com/richardmiller/PhpSpecExtension
[20]: https://github.com/richardmiller/PhpSpecRunExtension
[21]: https://github.com/richardmiller/ExemplifyExtension

