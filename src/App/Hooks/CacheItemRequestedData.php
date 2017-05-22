<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Hooks;

/**
 * @property string|null $action The action name that requested the data. Available values: get, getValue, exists.
 * @property string|null $key The key of the cache item.
 * @property bool|null $exists TRUE if an item with the key specified is found. FALSE otherwise.
 */
class CacheItemRequestedData
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
        $this->defineProperty('exists', [
            'type' => '?bool'
        ]);
    }

}
