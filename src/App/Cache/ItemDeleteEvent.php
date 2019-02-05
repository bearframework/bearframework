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
class ItemDeleteEvent extends \BearFramework\App\Event
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
                ])
        ;
        $this->key = $key;
    }

}
