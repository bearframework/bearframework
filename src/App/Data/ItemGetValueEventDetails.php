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
 * @property string|null $value
 */
class ItemGetValueEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * @param string $key
     * @param string|null $value
     */
    public function __construct(string $key, string $value = null)
    {
        $this
            ->defineProperty('key', [
                'type' => 'string'
            ])
            ->defineProperty('value', [
                'type' => '?string'
            ]);
        $this->key = $key;
        $this->value = $value;
    }
}
