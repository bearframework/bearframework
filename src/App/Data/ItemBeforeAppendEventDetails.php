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
 * @property bool $preventCompleteEvents
 */
class ItemBeforeAppendEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $key
     * @param string $content
     */
    public function __construct(string $key, string $content)
    {
        $this
            ->defineProperty('key', [
                'type' => 'string'
            ])
            ->defineProperty('content', [
                'type' => 'string'
            ])
            ->defineProperty('preventCompleteEvents', [
                'type' => 'bool',
                'init' => function () {
                    return false;
                }
            ]);
        $this->key = $key;
        $this->content = $content;
    }
}
