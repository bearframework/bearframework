<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Data;

/**
 * @property string $key
 * @property ?\BearFramework\App\DataItem $item
 */
class ItemGetEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * @param string $key
     * @param ?\BearFramework\App\DataItem $item
     */
    public function __construct(string $key, $item)
    {
        $this
                ->defineProperty('key', [
                    'type' => 'string'
                ])
                ->defineProperty('item', [
                    'type' => '?' . \BearFramework\App\DataItem::class
                ])
        ;
        $this->key = $key;
        $this->item = $item;
    }

}
