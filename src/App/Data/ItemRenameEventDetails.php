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
 */
class ItemRenameEventDetails
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
            ]);
        $this->sourceKey = $sourceKey;
        $this->destinationKey = $destinationKey;
    }
}
