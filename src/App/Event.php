<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * A base event object.
 * 
 * @property string $name The name of the event.
 */
class Event
{

    use \IvoPetkov\DataObjectTrait;
    use \IvoPetkov\DataObjectToArrayTrait;
    use \IvoPetkov\DataObjectToJSONTrait;

    /**
     * 
     * @param string $name The name of the event.
     */
    public function __construct(string $name)
    {
        $this->
                defineProperty('name', [
                    'get' => function() use ($name) {
                        return $name;
                    },
                    'readonly' => true,
        ]);
    }

}
