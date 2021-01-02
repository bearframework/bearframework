<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Data;

/**
 * @property \BearFramework\DataList|null $returnValue
 * @property bool $preventCompleteEvents
 */
class BeforeGetListEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     */
    public function __construct()
    {
        $this
            ->defineProperty('returnValue', [
                'type' => '?\BearFramework\DataList'
            ])
            ->defineProperty('preventCompleteEvents', [
                'type' => 'bool',
                'init' => function () {
                    return false;
                }
            ]);
    }
}
