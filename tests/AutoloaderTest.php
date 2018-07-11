<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * @runTestsInSeparateProcesses
 */
class AutoloaderTest extends BearFrameworkAutoloaderTestCase
{

    /**
     * 
     */
    public function testClasses()
    {
        $classes = [
            'BearFramework\App\Addon' => 'src/App/Addon.php',
            'BearFramework\App\AddonsRepository' => 'src/App/AddonsRepository.php',
            'BearFramework\App\Assets' => 'src/App/Assets.php',
            'BearFramework\App\CacheItem' => 'src/App/CacheItem.php',
            'BearFramework\App\CacheRepository' => 'src/App/CacheRepository.php',
            'BearFramework\App\ClassesRepository' => 'src/App/ClassesRepository.php',
            'BearFramework\App\Config' => 'src/App/Config.php',
            'BearFramework\App\Container' => 'src/App/Container.php',
            'BearFramework\App\Context' => 'src/App/Context.php',
            'BearFramework\App\Context\Assets' => 'src/App/Context/Assets.php',
            'BearFramework\App\Context\Classes' => 'src/App/Context/Classes.php',
            'BearFramework\App\ContextsRepository' => 'src/App/ContextsRepository.php',
            'BearFramework\App\Data\DataLockedException' => 'src/App/Data/DataLockedException.php',
            'BearFramework\App\DataItem' => 'src/App/DataItem.php',
            'BearFramework\App\DataRepository' => 'src/App/DataRepository.php',
            'BearFramework\App\DefaultCacheDriver' => 'src/App/DefaultCacheDriver.php',
            'BearFramework\App\DefaultLogger' => 'src/App/DefaultLogger.php',
            'BearFramework\App\ErrorHandler' => 'src/App/ErrorHandler.php',
            'BearFramework\App\HooksRepository' => 'src/App/HooksRepository.php',
            'BearFramework\App\ICacheDriver' => 'src/App/ICacheDriver.php',
            'BearFramework\App\ILogger' => 'src/App/ILogger.php',
            'BearFramework\App\Images' => 'src/App/Images.php',
            'BearFramework\App\Request' => 'src/App/Request.php',
            'BearFramework\App\Request\Cookie' => 'src/App/Request/Cookie.php',
            'BearFramework\App\Request\CookiesRepository' => 'src/App/Request/CookiesRepository.php',
            'BearFramework\App\Request\FormDataItem' => 'src/App/Request/FormDataItem.php',
            'BearFramework\App\Request\FormDataFileItem' => 'src/App/Request/FormDataFileItem.php',
            'BearFramework\App\Request\FormDataRepository' => 'src/App/Request/FormDataRepository.php',
            'BearFramework\App\Request\Header' => 'src/App/Request/Header.php',
            'BearFramework\App\Request\HeadersRepository' => 'src/App/Request/HeadersRepository.php',
            'BearFramework\App\Request\PathRepository' => 'src/App/Request/PathRepository.php',
            'BearFramework\App\Request\QueryItem' => 'src/App/Request/QueryItem.php',
            'BearFramework\App\Request\QueryRepository' => 'src/App/Request/QueryRepository.php',
            'BearFramework\App\Response' => 'src/App/Response.php',
            'BearFramework\App\Response\Cookie' => 'src/App/Response/Cookie.php',
            'BearFramework\App\Response\CookiesRepository' => 'src/App/Response/CookiesRepository.php',
            'BearFramework\App\Response\FileReader' => 'src/App/Response/FileReader.php',
            'BearFramework\App\Response\HTML' => 'src/App/Response/HTML.php',
            'BearFramework\App\Response\Header' => 'src/App/Response/Header.php',
            'BearFramework\App\Response\HeadersRepository' => 'src/App/Response/HeadersRepository.php',
            'BearFramework\App\Response\JSON' => 'src/App/Response/JSON.php',
            'BearFramework\App\Response\NotFound' => 'src/App/Response/NotFound.php',
            'BearFramework\App\Response\PermanentRedirect' => 'src/App/Response/PermanentRedirect.php',
            'BearFramework\App\Response\TemporaryRedirect' => 'src/App/Response/TemporaryRedirect.php',
            'BearFramework\App\Response\TemporaryUnavailable' => 'src/App/Response/TemporaryUnavailable.php',
            'BearFramework\App\Response\Text' => 'src/App/Response/Text.php',
            'BearFramework\App\RoutesRepository' => 'src/App/RoutesRepository.php',
            'BearFramework\App\ShortcutsRepository' => 'src/App/ShortcutsRepository.php',
            'BearFramework\App\Urls' => 'src/App/Urls.php',
            'BearFramework\Addon' => 'src/Addon.php',
            'BearFramework\Addons' => 'src/Addons.php',
            'BearFramework\App' => 'src/App.php',
            'BearFramework\DataList' => 'src/DataList.php',
        ];

        $classes = array_keys($classes);
        foreach ($classes as $class) {
            $this->assertTrue(class_exists($class) || interface_exists($class));
        }
    }

}
