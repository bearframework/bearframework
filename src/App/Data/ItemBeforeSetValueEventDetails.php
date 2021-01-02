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
 * @property string $value
 * @property bool $preventCompleteEvents
 */
class ItemBeforeSetValueEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $key
     * @param string $value
     */
    public function __construct(string $key, string $value)
    {
        $this
            ->defineProperty('key', [
                'type' => 'string'
            ])
            ->defineProperty('value', [
                'type' => 'string'
            ])
            ->defineProperty('preventCompleteEvents', [
                'type' => 'bool',
                'init' => function () {
                    return false;
                }
            ]);
        $this->key = $key;
        $this->value = $value;
    }
}
