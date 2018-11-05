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
 * @property string $content
 */
class ItemAppendEvent extends \BearFramework\App\Event
{

    /**
     * 
     * @param string $key
     * @param string $content
     */
    public function __construct(string $key, string $content)
    {
        parent::__construct('itemAppend');
        $this
                ->defineProperty('key', [
                    'type' => 'string'
                ])
                ->defineProperty('content', [
                    'type' => 'string'
                ])
        ;
        $this->key = $key;
        $this->content = $content;
    }

}
