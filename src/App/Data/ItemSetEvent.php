<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Data;

/**
 * @property \BearFramework\App\DataItem $item
 */
class ItemSetEvent extends \BearFramework\App\Event
{

    /**
     * 
     * @param \BearFramework\App\DataItem $item
     */
    public function __construct(\BearFramework\App\DataItem $item)
    {
        parent::__construct('itemSet');
        $this
                ->defineProperty('item', [
                    'type' => \BearFramework\App\DataItem::class
                ])
        ;
        $this->item = $item;
    }

}
