<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;

/**
 * Context locator
 */
class ContextsRepository
{

    private static $cache = [];

    /**
     * Creates a context object for the filename specified
     * 
     * @param string $filename
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @return \BearFramework\App\Context The context object
     */
    public function get(string $filename)
    {
        $filename = realpath($filename);
        if (isset(self::$cache[$filename])) {
            return self::$cache[$filename];
        }
        if ($filename === false) {
            throw new \Exception('File does not exists');
        }
        $app = App::get();
        if (strpos($filename, $app->config->appDir . DIRECTORY_SEPARATOR) === 0) {
            self::$cache[$filename] = new App\Context($app->config->appDir);
            return self::$cache[$filename];
        }
        $addons = $app->addons->getList();
        foreach ($addons as $addon) {
            $registeredAddon = \BearFramework\Addons::get($addon->id);
            if (strpos($filename, $registeredAddon->dir . DIRECTORY_SEPARATOR) === 0) {
                self::$cache[$filename] = new App\Context($registeredAddon->dir);
                return self::$cache[$filename];
            }
        }
        throw new \Exception('Connot find context');
    }

}
