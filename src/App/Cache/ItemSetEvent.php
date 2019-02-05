<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Cache;

/**
 * @property \BearFramework\App\CacheItem $item
 */
class ItemSetEvent extends \BearFramework\App\Event
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param \BearFramework\App\CacheItem $item
     */
    public function __construct(\BearFramework\App\CacheItem $item)
    {
        $this
                ->defineProperty('item', [
                    'type' => \BearFramework\App\CacheItem::class
                ])
        ;
        $this->item = $item;
    }

}
