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
 * @property bool $exists
 */
class ItemExistsEvent extends \BearFramework\App\Event
{

    /**
     * @param string $key
     * @param bool $exists
     */
    public function __construct(string $key, bool $exists)
    {
        parent::__construct('itemExists');
        $this
                ->defineProperty('key', [
                    'type' => 'string'
                ])
                ->defineProperty('exists', [
                    'type' => 'bool'
                ])
        ;
        $this->key = $key;
        $this->exists = $exists;
    }

}
