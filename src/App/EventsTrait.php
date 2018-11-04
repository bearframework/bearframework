<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * 
 */
trait EventsTrait
{

    private $internalEventListenersData = [];

    /**
     * 
     * @param string $name
     * @param callable $listener
     * @return void
     */
    public function addEventListener(string $name, callable $listener): void
    {
        if (!isset($this->internalEventListenersData[$name])) {
            $this->internalEventListenersData[$name] = [];
        }
        $this->internalEventListenersData[$name][] = $listener;
    }

    /**
     * 
     * @param string $name
     * @param callable $listener
     * @return void
     */
    public function removeEventListener(string $name, callable $listener): void
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
    }

    /**
     * 
     * @param \BearFramework\App\Event $event
     * @return void
     */
    public function dispatchEvent(\BearFramework\App\Event $event): void
    {
        $name = $event->name;
        if (isset($this->internalEventListenersData[$name])) {
            foreach ($this->internalEventListenersData[$name] as $listener) {
                call_user_func($listener, $event);
            }
        }
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
