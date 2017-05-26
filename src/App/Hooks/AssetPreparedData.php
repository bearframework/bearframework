<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Hooks;

/**
 * @property string|null $filename The file that is returned as a response.
 */
class AssetPreparedData
{

    use \IvoPetkov\DataObjectTrait;

    function __construct()
    {
        $this->defineProperty('filename', [
            'type' => '?string'
        ]);
    }

}
