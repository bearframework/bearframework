<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework;

/**
 * 
 */
trait EventsTrait
{

    /**
     *
     * @var array 
     */
    private $internalEventListenersData = [];

    /**
     * Registers a new event listener.
     * 
     * @param string $name The name of the event.
     * @param callable $listener A listener callback.
     * @return self Returns a reference to itself.
     */
    public function addEventListener(string $name, callable $listener): self
    {
        if (!isset($this->internalEventListenersData[$name])) {
            $this->internalEventListenersData[$name] = [];
        }
        $this->internalEventListenersData[$name][] = $listener;
        return $this;
    }

    /**
     * Removes a registered event listener.
     * 
     * @param string $name The name of the event.
     * @param callable $listener A listener callback.
     * @return self Returns a reference to itself.
     */
    public function removeEventListener(string $name, callable $listener): self
    {
        if (isset($this->internalEventListenersData[$name])) {
            foreach ($this->internalEventListenersData[$name] as $i => $value) {
                if ($value === $listener) {
                    unset($this->internalEventListenersData[$name][$i]);
                    if (empty($this->internalEventListenersData[$name])) {
                        unset($this->internalEventListenersData[$name]);
                    }
                    break;
                }
            }
        }
        return $this;
    }

    /**
     * Calls the registered listeners (in order) for the event name specified.
     * 
     * @param string $name The name of the event.
     * @param mixed $details Additional event data.
     * @return self Returns a reference to itself.
     */
    public function dispatchEvent(string $name, $details = null): self
    {
        if (isset($this->internalEventListenersData[$name])) {
            foreach ($this->internalEventListenersData[$name] as $listener) {
                call_user_func($listener, $details);
            }
        }
        return $this;
    }

    /**
     * Returns TRUE if there are registered event listeners for the name specified, FALSE otherwise.
     * 
     * @param string $name The name of the event.
     * @return bool Returns TRUE if there are registered event listeners for the name specified, FALSE otherwise.
     */
    public function hasEventListeners(string $name): bool
    {
        return isset($this->internalEventListenersData[$name]);
    }

}
