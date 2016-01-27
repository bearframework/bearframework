<p align="center">
<img src="http://bearframework.github.io/bearframework-logo-transparent-small.png" style="max-width:100px;">
</p>
# Bear Framework

**A true 2016 framework**

The goal of Bear Framework is to help you start your next web project in less than a minute and help you make it successful. You've got routing, data storage, addons, logging, assets helpers, HTML Server Components and many more useful tools.

[![Latest Stable Version](https://poser.pugx.org/bearframework/bearframework/v/stable)](https://packagist.org/packages/bearframework/bearframework)
[![License](https://poser.pugx.org/bearframework/bearframework/license)](https://packagist.org/packages/bearframework/bearframework)

## Simple and powerful

Bear Framework is one of the easiest PHP frameworks you can find. See for yourself. Here is a simple app that outputs 'Hi'.
```
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
php composer.phar require bearframework/bearframework
```

* Download the zip file

Download the [latest release](https://github.com/bearframework/bearframework/releases) from our GitHub page.

## Documentation
Documentation is available at [http://bearframework.com/documentation/](http://bearframework.com/documentation/).

## License
Bear Framework is open-sourced software. It's free to use under the MIT license. See the [license file](https://github.com/bearframework/bearframework/blob/master/LICENSE) for more information.

## Let's talk
Follow and contact Bear Framework team at [bearframework.com](http://bearframework.com), [Twitter (@bearframework)](https://twitter.com/bearframework) and [Facebook](https://www.facebook.com/bearframework/).