# README

[![Travis Build Status](https://api.travis-ci.com/bresam/ivory-json-builder.svg?branch=master)](https://travis-ci.com/github/bresam/ivory-json-builder)
[![Code Coverage](https://scrutinizer-ci.com/g/bresam/ivory-json-builder/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bresam/ivory-json-builder/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bresam/ivory-json-builder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bresam/ivory-json-builder/?branch=master)

The Ivory JSON builder is a PHP 7.0+ library allowing you to build your JSON through the Symfony2
[PropertyAccess](http://symfony.com/doc/current/components/property_access/index.html) component while keeping the
control of the value escaping.

``` php
use Ivory\JsonBuilder\JsonBuilder;

$builder = new JsonBuilder();
$json = $builder
    ->setValues(array('foo' => array('bar')))
    ->setValue('[baz]', 'bat', false)
    ->build();

// {"foo":["bar"],"baz":bat}
echo $json;
```

## Documentation

 * [Installation](/doc/installation.md)
 * [Usage](/doc/usage.md)
 * [Development Environment](/doc/development_environment.md)

## Testing

The library is fully unit tested by [PHPUnit](http://www.phpunit.de/) with a code coverage close to **100%**. To
execute the test suite, check the travis [configuration](/.travis.yml).

## Contribution

We love contributors! Ivory is an open source project. If you'd like to contribute, feel free to propose a PR! You
can follow the [CONTRIBUTING](/CONTRIBUTING.md) file which will explain you how to set up the project.

## License

The Ivory JSON Builder is under the MIT license. For the full copyright and license information, please read the
[LICENSE](/LICENSE) file that was distributed with this source code.
