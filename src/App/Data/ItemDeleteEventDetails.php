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
 */
class ItemDeleteEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this
            ->defineProperty('key', [
                'type' => 'string'
            ]);
        $this->key = $key;
    }
}
