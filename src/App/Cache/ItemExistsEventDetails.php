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
 * @property bool $exists
 */
class ItemExistsEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * @param string $key
     * @param bool $exists
     */
    public function __construct(string $key, bool $exists)
    {
        $this
                ->defineProperty('key', [
                    'type' => 'string'
                ])
                ->defineProperty('exists', [
                    'type' => 'bool',
                    'init' => function () {
                        return false;
                    }
                ])
        ;
        $this->key = $key;
        $this->exists = $exists;
    }

}
