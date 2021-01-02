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
 * @property string $mode
 * @property \BearFramework\App\IDataItemStreamWrapper|null $returnValue
 */
class ItemBeforeGetStreamWrapperEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * @param string $key
     * @param string $mode
     */
    public function __construct(string $key, string $mode)
    {
        $this
            ->defineProperty('key', [
                'type' => 'string'
            ])
            ->defineProperty('mode', [
                'type' => 'string'
            ])
            ->defineProperty('returnValue', [
                'type' => '?\BearFramework\App\IDataItemStreamWrapper'
            ]);
        $this->key = $key;
        $this->mode = $mode;
    }
}
