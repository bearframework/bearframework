<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Cache;

/**
 * @property string $key
 * @property mixed $value
 */
class ItemGetValueEvent extends \BearFramework\App\Event
{

    /**
     * @param string $key
     * @param mixed $value
     */
    public function __construct(string $key, $value)
    {
        parent::__construct('itemGetValue');
        $this
                ->defineProperty('key', [
                    'type' => 'string'
                ])
                ->defineProperty('value')
        ;
        $this->key = $key;
        $this->value = $value;
    }

}
