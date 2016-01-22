<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

class AddonContext extends \App\Context
{

    /**
     * 
     * @return array
     */
    function getOptions()
    {
        $app = &\App::$instance;
        $addonID = rtrim(str_replace($app->config->addonsDir, '', $this->dir), '/');
        return $app->addons->getOptions($addonID);
    }

}
