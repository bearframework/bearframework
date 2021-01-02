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
 * @property string $name
 * @property string $value
 * @property bool $preventCompleteEvents
 */
class ItemBeforeSetMetadataEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $key
     * @param string $name
     * @param string $value
     */
    public function __construct(string $key, string $name, string $value)
    {
        $this
            ->defineProperty('key', [
                'type' => 'string'
            ])
            ->defineProperty('name', [
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
        $this->name = $name;
        $this->value = $value;
    }
}
