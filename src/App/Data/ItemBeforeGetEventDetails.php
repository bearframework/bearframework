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
 * @property \BearFramework\App\DataItem|null $returnValue
 * @property bool $preventCompleteEvents
 */
class ItemBeforeGetEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this
            ->defineProperty('key', [
                'type' => 'string'
            ])
            ->defineProperty('returnValue', [
                'type' => '?\BearFramework\App\DataItem'
            ])
            ->defineProperty('preventCompleteEvents', [
                'type' => 'bool',
                'init' => function () {
                    return false;
                }
            ]);
        $this->key = $key;
    }
}
