<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
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
    use \IvoPetkov\DataObjectToArrayTrait;
    use \IvoPetkov\DataObjectToJSONTrait;

    public function __construct()
    {
        $this
                ->defineProperty('key', [
                    'type' => '?string'
                ])
                ->defineProperty('value')
                ->defineProperty('ttl', [
                    'type' => '?int'
                ]);
    }

}
