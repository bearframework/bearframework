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
        return $app->addons->getOptions();
    }

}
