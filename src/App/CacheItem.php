<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * @property string $key
 * @property mixed $value
 * @property int|null $ttl Time in seconds to stay in the cache
 */
class CacheItem implements \IvoPetkov\DataObjectInterface
{

    use \IvoPetkov\DataObjectTrait;

    function __construct(string $key, $value)
    {
        $this->key = $key;
        $this->value = $value;
        $this->ttl = null;
    }

}
