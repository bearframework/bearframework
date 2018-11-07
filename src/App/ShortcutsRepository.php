<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Shortcuts container for the application object.
 * 
 * @codeCoverageIgnore
 */
class ShortcutsRepository
{

    /**
     *
     * @var callable 
     */
    private $addCallback = null;

    /**
     * 
     * @param callable $addCallback
     */
    public function __construct(callable $addCallback)
    {
        $this->addCallback = $addCallback;
    }

    /**
     * Creates a new shortcut.
     * 
     * @param string $name The name of the shortcut property.
     * @param callable $callback The callback to return the shortcut value.
     * @return self Returns a reference to itself.
     */
    public function add(string $name, callable $callback): self
    {
        call_user_func($this->addCallback, $name, $callback);
        return $this;
    }

}
