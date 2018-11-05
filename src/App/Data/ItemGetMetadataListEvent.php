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
 * @property \BearFramework\DataList $list
 */
class ItemGetMetadataListEvent extends \BearFramework\App\Event
{

    /**
     * 
     * @param string $key
     * @param \BearFramework\DataList $list
     */
    public function __construct(string $key, \BearFramework\DataList $list)
    {
        parent::__construct('itemGetMetadataList');
        $this
                ->defineProperty('key', [
                    'type' => 'string'
                ])
                ->defineProperty('list', [
                    'type' => '\BearFramework\DataList'
                ])
        ;
        $this->key = $key;
        $this->list = $list;
    }

}
