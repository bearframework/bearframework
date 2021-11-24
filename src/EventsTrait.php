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
                    } else {
                        $this->internalEventListenersData[$name] = array_values($this->internalEventListenersData[$name]); // Correct indexes are needed in dispatchEvent()
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
     * @param array $options Dispatch options. Available values: defaultListener.
     * @return self Returns a reference to itself.
     */
    public function dispatchEvent(string $name, $details = null, $options = []): self
    {
        $hasDefaultListener = isset($options['defaultListener']);
        if (isset($this->internalEventListenersData[$name])) {
            $canceled = false;
            $cancelable = isset($options['cancelable']) && $options['cancelable'] === true;
            $dispatcher = new class(
                function () use (&$canceled, $cancelable, $name) {
                    if (!$cancelable) {
                        throw new \Exception('This event "' . $name . '" cannot be canceled!');
                    }
                    $canceled = true;
                },
                function () use (&$executeNext) {
                    $executeNext();
                }
            )
            {
                public $canceledCallback = null;
                public $executeNextCallback = null;

                public function __construct(callable $canceledCallback, callable $executeNextCallback)
                {
                    $this->canceledCallback = $canceledCallback;
                    $this->executeNextCallback = $executeNextCallback;
                }

                public function cancel()
                {
                    call_user_func($this->canceledCallback);
                }

                public function continue()
                {
                    call_user_func($this->executeNextCallback);
                }
            };

            $nextIndex = 0;
            $lastIndex = sizeof($this->internalEventListenersData[$name]) - 1;

            $executeNext = function () use (&$executeNext, $name, $dispatcher, &$nextIndex, $lastIndex, $details, $hasDefaultListener, $options, &$canceled) {
                if ($nextIndex <= $lastIndex) {
                    $listener = $this->internalEventListenersData[$name][$nextIndex];
                    $nextIndex++;
                    call_user_func($listener, $details, $dispatcher);
                    if ($canceled) {
                        return;
                    }
                } elseif ($nextIndex === $lastIndex + 1) {
                    $nextIndex++;
                    if ($hasDefaultListener) {
                        call_user_func($options['defaultListener'], $details);
                    }
                } else {
                    return;
                }
                $executeNext();
            };
            $executeNext();
        } else {
            if ($hasDefaultListener) {
                call_user_func($options['defaultListener'], $details);
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
