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
 * @property bool $preventCompleteEvents
 */
class ItemBeforeSetEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param \BearFramework\App\DataItem $item
     */
    public function __construct(\BearFramework\App\DataItem $item)
    {
        $this
            ->defineProperty('item', [
                'type' => \BearFramework\App\DataItem::class
            ])
            ->defineProperty('preventCompleteEvents', [
                'type' => 'bool',
                'init' => function () {
                    return false;
                }
            ]);
        $this->item = $item;
    }
}
