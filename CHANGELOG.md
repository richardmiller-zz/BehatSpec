# Change Log
All notable changes to this project will be documented in this file.

## 0.2.0 - 2014-11-12
### Added
- Added [PhpSpecRunExtension](https://github.com/richardmiller/PhpSpecRunExtension) to execute the phpspec run
command after describing missing classes/methods.

- Bumped to ~0.2 of the [ExemplifyExtension](https://github.com/richardmiller/ExemplifyExtension). Which adds:
    - Asking whether an `instance method`, `static method` or `name constructor`
is being described
    - Checking to see if the method has already been described and only
adding the example if it hasn't.

