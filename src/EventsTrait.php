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
     * 
     * @param string $name
     * @param callable $listener
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
     * 
     * @param string $name
     * @param callable $listener
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
     * 
     * @param string $name
     * @param mixed $details
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
     * 
     * @param string $name
     * @return bool
     */
    public function hasEventListeners(string $name): bool
    {
        return isset($this->internalEventListenersData[$name]);
    }

}
