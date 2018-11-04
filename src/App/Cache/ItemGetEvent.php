<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Cache;

/**
 * @property string $key
 * @property ?\BearFramework\App\CacheItem $item
 */
class ItemGetEvent extends \BearFramework\App\Event
{

    /**
     * @param string $key
     * @param ?\BearFramework\App\CacheItem $item
     */
    public function __construct(string $key, $item)
    {
        parent::__construct('itemGet');
        $this
                ->defineProperty('key', [
                    'type' => 'string'
                ])
                ->defineProperty('item', [
                    'type' => '?' . \BearFramework\App\CacheItem::class
                ])
        ;
        $this->key = $key;
        $this->item = $item;
    }

}
