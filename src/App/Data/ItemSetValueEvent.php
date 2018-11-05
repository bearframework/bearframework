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
 */
class ItemSetValueEvent extends \BearFramework\App\Event
{

    /**
     * 
     * @param string $key
     * @param string $value
     */
    public function __construct(string $key, string $value)
    {
        parent::__construct('itemSetValue');
        $this
                ->defineProperty('key', [
                    'type' => 'string'
                ])
                ->defineProperty('value', [
                    'type' => 'string'
                ])
        ;
        $this->key = $key;
        $this->value = $value;
    }

}
