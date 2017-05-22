<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Hooks;

/**
 * @property string|null $action The action name that changed the data. Available values: set, delete.
 * @property string|null $key The key of the cache item.
 */
class CacheItemChangedData
{

    use \IvoPetkov\DataObjectTrait;

    function __construct()
    {
        $this->defineProperty('action', [
            'type' => '?string'
        ]);
        $this->defineProperty('key', [
            'type' => '?string'
        ]);
    }

}
