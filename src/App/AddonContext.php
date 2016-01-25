<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

/**
 * Provides information about the addon location and utility functions
 */
class AddonContext extends \App\Context
{

    /**
     * Returns the options set for the current addon
     * @return array The options set for the current addon
     */
    function getOptions()
    {
        $app = &\App::$instance;
        $addonID = rtrim(str_replace($app->config->addonsDir, '', $this->dir), '/');
        return $app->addons->getOptions($addonID);
    }

}
