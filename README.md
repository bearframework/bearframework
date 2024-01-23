![Bear Framework](https://bearframework.github.io/bearframework-logo-for-github.png)

**Incredibly lightweight. Powerful enough.**

An open-source **PHP framework** that can help you build successful projects better. It's also easy to install and extend. Just like you'd expect from a modern framework.

Bear Framework provides all the basic tools you need to develop a modern website or application. You've got <a href="http://bearframework.com/docs/latest/routing/">routing</a>, <a href="http://bearframework.com/docs/latest/data/">data storage</a>, <a href="http://bearframework.com/docs/latest/addons/">addons</a>, <a href="http://bearframework.com/docs/latest/logs/">logs</a>, <a href="http://bearframework.com/docs/latest/assets/">assets helpers</a> and <a href="http://bearframework.com/docs/latest/">few more useful tools</a>.

[![Latest Stable Version](https://poser.pugx.org/bearframework/bearframework/v/stable)](https://packagist.org/packages/bearframework/bearframework)
[![License](https://poser.pugx.org/bearframework/bearframework/license)](https://packagist.org/packages/bearframework/bearframework)

## Simple and powerful

Bear Framework is one of the easiest PHP frameworks you can find. See for yourself. Here is a simple app that outputs 'Hi'.
```php
<?php
require 'path/to/vendor/autoload.php';
use BearFramework\App;

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

* Download a zip/phar file

Download the [latest release](https://github.com/bearframework/bearframework/releases) from our GitHub page.

## Documentation
Documentation is available at [http://bearframework.com/docs/](http://bearframework.com/docs/).

## How to run the tests
After installing the dependencies with Composer, you will have a local version of PHPUnit. You can run the tests like this: `vendor/bin/phpunit tests/`.

## License
Bear Framework is open-source software. It's free to use under the MIT license. See the [license file](https://github.com/bearframework/bearframework/blob/master/LICENSE) for more information.

## Let's talk
Follow and contact Bear Framework team at [bearframework.com](http://bearframework.com), [Twitter (@bearframework)](https://twitter.com/bearframework) and [Facebook](https://www.facebook.com/bearframework/).
