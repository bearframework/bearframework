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
 */
class ItemRequestEvent extends \BearFramework\App\Event
{

    /**
     * 
     * @param string $key
     */
    public function __construct(string $key)
    {
        parent::__construct('itemRequest');
        $this
                ->defineProperty('key', [
                    'type' => 'string'
                ])
        ;
        $this->key = $key;
    }

}
