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
 * @property string|null $returnValue
 * @property bool $preventCompleteEvents
 */
class ItemBeforeGetMetadataEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $key
     * @param string $name
     */
    public function __construct(string $key, string $name)
    {
        $this
            ->defineProperty('key', [
                'type' => 'string'
            ])
            ->defineProperty('name', [
                'type' => 'string'
            ])
            ->defineProperty('returnValue', [
                'type' => '?string'
            ])
            ->defineProperty('preventCompleteEvents', [
                'type' => 'bool',
                'init' => function () {
                    return false;
                }
            ]);
        $this->key = $key;
        $this->name = $name;
    }
}
