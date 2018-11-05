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
 */
class Event
{

    use \IvoPetkov\DataObjectTrait;

    /**
     *
     * @var string 
     */
    private $name = null;

    /**
     * 
     * @param string $name The name of the event.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}
