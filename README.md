<p align="center">
<img src="http://bearframework.github.io/bearframework-logo-transparent-small.png" style="max-width:100px;">
</p>
# Bear Framework

**A framework born in 2016**

The goal of Bear Framework is to help you start your next web project in less than a minute and help you make it successful. You've got <a href="http://bearframework.com/documentation/routing/">routing</a>, <a href="http://bearframework.com/documentation/data/">data storage</a>, <a href="http://bearframework.com/documentation/addons/">addons</a>, <a href="http://bearframework.com/documentation/logging/">logging</a>, <a href="http://bearframework.com/documentation/assets/">assets helpers</a> and <a href="http://bearframework.com/documentation/">many more useful tools</a>.

[![Build Status](https://travis-ci.org/bearframework/bearframework.svg)](https://travis-ci.org/bearframework/bearframework)
[![Latest Stable Version](https://poser.pugx.org/bearframework/bearframework/v/stable)](https://packagist.org/packages/bearframework/bearframework)
[![codecov.io](https://codecov.io/github/bearframework/bearframework/coverage.svg?branch=master)](https://codecov.io/github/bearframework/bearframework?branch=master)
[![License](https://poser.pugx.org/bearframework/bearframework/license)](https://packagist.org/packages/bearframework/bearframework)
[![Codacy Badge](https://api.codacy.com/project/badge/grade/36a41361218145539175d0fc7b153f0f)](https://www.codacy.com/app/ivo_2/bearframework)

## Simple and powerful

Bear Framework is one of the easiest PHP frameworks you can find. See for yourself. Here is a simple app that outputs 'Hi'.
```php
<?php
require 'vendor/autoload.php';

$app = new App();

$app->routes->add('/', function() {
    return new App\Response('Hi');
});

$app->run();
```

## Download and install

* Install via Composer
```
composer require bearframework/bearframework
```
or the following command to create a sleketon application
```
composer create-project bearframework/app [my-app-name]
```

* Download the zip file

Download the [latest release](https://github.com/bearframework/bearframework/releases) from our GitHub page.

## Documentation
Documentation is available at [http://bearframework.com/documentation/](http://bearframework.com/documentation/).

## How to run the tests
After installing the dependencies with Composer, you will have a local version of PHPUnit. You can run the tests like this: `vendor/bin/phpunit tests/`.

## License
Bear Framework is open-sourced software. It's free to use under the MIT license. See the [license file](https://github.com/bearframework/bearframework/blob/master/LICENSE) for more information.

## Let's talk
Follow and contact Bear Framework team at [bearframework.com](http://bearframework.com), [Twitter (@bearframework)](https://twitter.com/bearframework) and [Facebook](https://www.facebook.com/bearframework/).
