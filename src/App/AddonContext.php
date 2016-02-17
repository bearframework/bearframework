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
 * Provides information about the addon location and utility functions
 */
class AddonContext extends \BearFramework\App\Context
{

    /**
     * The constructor
     * @param string $dir The directory where the current addond is located 
     * @throws \InvalidArgumentException
     */
    public function __construct($dir)
    {
        if (!is_string($dir)) {
            throw new \InvalidArgumentException('');
        }
        parent::__construct($dir);
    }

    /**
     * Returns the options set for the current addon
     * @throws \BearFramework\App\InvalidConfigOptionException
     * @return array The options set for the current addon
     */
    public function getOptions()
    {
        $app = &App::$instance;
        if ($app->config->addonsDir === null) {
            throw new App\InvalidConfigOptionException('Config option addonsDir not set');
        }
        $addonID = rtrim(str_replace($app->config->addonsDir, '', $this->dir), '/');
        return $app->addons->getOptions($addonID);
    }

}
