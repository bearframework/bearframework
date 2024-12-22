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
 * @property int|null $length
 */
class ItemGetValueLengthEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * @param string $key
     * @param int|null $length
     */
    public function __construct(string $key, ?int $length = null)
    {
        $this
            ->defineProperty('key', [
                'type' => 'string'
            ])
            ->defineProperty('length', [
                'type' => '?int'
            ]);
        $this->key = $key;
        $this->length = $length;
    }
}
