<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Data;

/**
 * @property \BearFramework\DataList $list
 */
class GetListEvent extends \BearFramework\App\Event
{

    /**
     * 
     * @param \BearFramework\DataList $list
     */
    public function __construct(\BearFramework\DataList $list)
    {
        parent::__construct('getList');
        $this
                ->defineProperty('list', [
                    'type' => '\BearFramework\DataList'
                ])
        ;
        $this->list = $list;
    }

}
