<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Cache;

/**
 * 
 */
class ClearEvent extends \BearFramework\App\Event
{

    /**
     * 
     */
    public function __construct()
    {
        parent::__construct('clear');
    }

}
