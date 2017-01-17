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
class ContextLocator
{

    /**
     * Creates a context object for the filename specified
     * 
     * @param string $filename
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @return \BearFramework\App\Context The context object
     */
    public function get($filename)
    {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('The filename argument must be of type string');
        }
        $filename = realpath($filename);
        if ($filename === false) {
            throw new \Exception('File does not exists');
        }
        if (is_dir($filename)) {
            $filename .= DIRECTORY_SEPARATOR;
        }
        $app = App::get();
        if (strpos($filename, $app->config->appDir . DIRECTORY_SEPARATOR) === 0) {
            return new App\Context($app->config->appDir);
        }
        $addons = $app->addons->getList();
        foreach ($addons as $addon) {
            $addonData = \BearFramework\Addons::get($addon->id);
            if (strpos($filename, $addonData['dir'] . DIRECTORY_SEPARATOR) === 0) {
                return new App\Context($addonData['dir']);
            }
        }
        throw new \Exception('Connot find context');
    }

}
