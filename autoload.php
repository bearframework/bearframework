<?php

/*
 * Video embed
 * https://github.com/ivopetkov/video-embed
 * Copyright 2016, Ivo Petkov
 * Free to use under the MIT license.
 */

$classes = array(
    'BearFramework\App\Addons' => 'src/App/Addons.php',
    'BearFramework\App\Assets' => 'src/App/Assets.php',
    'BearFramework\App\Cache' => 'src/App/Cache.php',
    'BearFramework\App\Classes' => 'src/App/Classes.php',
    'BearFramework\App\Config' => 'src/App/Config.php',
    'BearFramework\App\Config\InvalidOptionException' => 'src/App/Config/InvalidOptionException.php',
    'BearFramework\App\Container' => 'src/App/Container.php',
    'BearFramework\App\Context' => 'src/App/Context.php',
    'BearFramework\App\Context\Assets' => 'src/App/Context/Assets.php',
    'BearFramework\App\Context\Classes' => 'src/App/Context/Classes.php',
    'BearFramework\App\Data' => 'src/App/Data.php',
    'BearFramework\App\Data\DataLockedException' => 'src/App/Data/DataLockedException.php',
    'BearFramework\App\Hooks' => 'src/App/Hooks.php',
    'BearFramework\App\Images' => 'src/App/Images.php',
    'BearFramework\App\Logger' => 'src/App/Logger.php',
    'BearFramework\App\Request' => 'src/App/Request.php',
    'BearFramework\App\Request\Cookies' => 'src/App/Request/Cookies.php',
    'BearFramework\App\Request\Data' => 'src/App/Request/Data.php',
    'BearFramework\App\Request\Files' => 'src/App/Request/Files.php',
    'BearFramework\App\Request\Headers' => 'src/App/Request/Headers.php',
    'BearFramework\App\Request\Path' => 'src/App/Request/Path.php',
    'BearFramework\App\Request\Query' => 'src/App/Request/Query.php',
    'BearFramework\App\Response' => 'src/App/Response.php',
    'BearFramework\App\Response\Cookies' => 'src/App/Response/Cookies.php',
    'BearFramework\App\Response\FileReader' => 'src/App/Response/FileReader.php',
    'BearFramework\App\Response\HTML' => 'src/App/Response/HTML.php',
    'BearFramework\App\Response\Headers' => 'src/App/Response/Headers.php',
    'BearFramework\App\Response\JSON' => 'src/App/Response/JSON.php',
    'BearFramework\App\Response\NotFound' => 'src/App/Response/NotFound.php',
    'BearFramework\App\Response\PermanentRedirect' => 'src/App/Response/PermanentRedirect.php',
    'BearFramework\App\Response\TemporaryRedirect' => 'src/App/Response/TemporaryRedirect.php',
    'BearFramework\App\Response\TemporaryUnavailable' => 'src/App/Response/TemporaryUnavailable.php',
    'BearFramework\App\Response\Text' => 'src/App/Response/Text.php',
    'BearFramework\App\Routes' => 'src/App/Routes.php',
    'BearFramework\App\Urls' => 'src/App/Urls.php',
    'BearFramework\Addons' => 'src/Addons.php',
    'BearFramework\App' => 'src/App.php',
);

spl_autoload_register(function ($class) use ($classes) {
    if (isset($classes[$class])) {
        require __DIR__ . '/' . $classes[$class];
    }
}, true);

require __DIR__ . '/vendor/ivopetkov/object-storage/autoload.php';
