<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Hooks;

/**
 * 
 */
class AssetPrepareData
{

    use \IvoPetkov\DataObjectTrait;

    function __construct()
    {
        $this->defineProperty('filename', [
            'type' => '?string'
        ]);
        $this->defineProperty('width', [
            'type' => '?int'
        ]);
        $this->defineProperty('height', [
            'type' => '?int'
        ]);
    }

}
