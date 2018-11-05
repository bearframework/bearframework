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
 */
class ItemDeleteMetadataEvent extends \BearFramework\App\Event
{

    /**
     * 
     * @param string $key
     * @param string $name
     */
    public function __construct(string $key, string $name)
    {
        parent::__construct('itemDeleteMetadata');
        $this
                ->defineProperty('key', [
                    'type' => 'string'
                ])
                ->defineProperty('name', [
                    'type' => 'string'
                ])
        ;
        $this->key = $key;
        $this->name = $name;
    }

}
