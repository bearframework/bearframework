<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Data;

/**
 * @property string $sourceKey
 * @property string $destinationKey
 * @property bool $preventCompleteEvents
 */
class ItemBeforeDuplicateEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $sourceKey
     * @param string $destinationKey
     */
    public function __construct(string $sourceKey, string $destinationKey)
    {
        $this
            ->defineProperty('sourceKey', [
                'type' => 'string'
            ])
            ->defineProperty('destinationKey', [
                'type' => 'string'
            ])
            ->defineProperty('preventCompleteEvents', [
                'type' => 'bool',
                'init' => function () {
                    return false;
                }
            ]);
        $this->sourceKey = $sourceKey;
        $this->destinationKey = $destinationKey;
    }
}
