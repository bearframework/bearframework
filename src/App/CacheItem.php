<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * @property string|null $key The key of the cache item.
 * @property mixed $value The value of the cache item.
 * @property int|null $ttl Time in seconds to stay in the cache.
 */
class CacheItem
{

    use \IvoPetkov\DataObjectTrait;

    function __construct()
    {
        $this->defineProperty('key', [
            'type' => '?string'
        ]);
        $this->defineProperty('value');
        $this->defineProperty('ttl', [
            'type' => '?int'
        ]);
    }

}
