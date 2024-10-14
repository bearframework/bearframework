<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;

/**
 * Provides functionality for registering callbacks for specific requests and executing them.
 */
class Routes
{

    /**
     * Stores the registered callbacks.
     * 
     * @var array 
     */
    private $data = [];

    /**
     * Registers a request handler.
     * 
     * @param string|string[] $pattern Path pattern or array of patterns. Can contain "?" (path segment) and "*" (matches everything). Can start with method name (GET, HEAD, POST, DELETE, PUT, PATCH, OPTIONS) or list of method names (GET|HEAD|POST).
     * @param callable|callable[] $callback Function that is expected to return object of type \BearFramework\App\Response.
     * @throws \InvalidArgumentException
     * @return self Returns a reference to itself.
     */
    public function add($pattern, $callback): self
    {
        if (is_string($pattern)) {
            if (!isset($pattern[0])) {
                throw new \InvalidArgumentException('The pattern argument must be a not empty string or array of not empty strings');
            }
            $pattern = [$pattern];
        } elseif (is_array($pattern)) {
            if (empty($pattern)) {
                throw new \InvalidArgumentException('The pattern argument must be a not empty string or array of not empty strings');
            }
            foreach ($pattern as $_pattern) {
                if (!is_string($_pattern)) {
                    throw new \InvalidArgumentException('The pattern argument must be a not empty string or array of not empty strings');
                }
                if (!isset($_pattern[0])) {
                    throw new \InvalidArgumentException('The pattern argument must be a not empty string or array of not empty strings');
                }
            }
        } else {
            throw new \InvalidArgumentException('The pattern argument must be a not empty string or array of not empty strings');
        }
        if (is_callable($callback)) {
            $callback = [$callback];
        } elseif (is_array($callback)) {
            if (empty($callback)) {
                throw new \InvalidArgumentException('The callback argument must be a valid callable or array of valid callables');
            }
            foreach ($callback as $_callback) {
                if (!is_callable($_callback)) {
                    throw new \InvalidArgumentException('The callback argument must be a valid callable or array of valid callables');
                }
            }
        } else {
            throw new \InvalidArgumentException('The callback argument must be a valid callable or array of valid callables');
        }
        $this->data[] = [$pattern, $callback];
        return $this;
    }

    /**
     * Finds the matching callback and returns its result.
     * 
     * @param \BearFramework\App\Request $request The request object to match against.
     * @throws \Exception
     * @return mixed The result of the matching callback. NULL if none.
     */
    public function getResponse(\BearFramework\App\Request $request)
    {
        $requestPath = (string) $request->path;
        $requestMethod = $request->method;
        foreach ($this->data as $route) {
            foreach ($route[0] as $pattern) {
                $matches = null;
                preg_match('/^(?:(?:((?:[A-Z]+\|){0,}[A-Z]+) )?)(.*+)/', $pattern, $matches);
                $patternMethods = '|' . ($matches[1] === '' ? 'GET' : $matches[1]) . '|';
                if (strpos($patternMethods, '|' . $requestMethod . '|') === false) {
                    continue;
                }
                $patternPath = $matches[2];
                if (preg_match('/^' . str_replace(['/', '?', '*'], ['\/', '[^\/]+?', '.+?'], $patternPath) . '$/u', $requestPath) === 1) {
                    foreach ($route[1] as $callable) {
                        if (!ob_start()) {
                            throw new \Exception('Cannot turn on output buffering!');
                        }
                        try {
                            $response = call_user_func($callable, $request);
                            ob_end_clean();
                        } catch (\Exception $e) {
                            ob_end_clean();
                            throw $e;
                        }
                        if ($response instanceof App\Response) {
                            return $response;
                        }
                    }
                    // continue searching
                }
            }
        }
        if ($request->method === 'HEAD') {
            $getRequest = clone ($request);
            $getRequest->method = 'GET';
            $response = $this->getResponse($getRequest);
            if ($response instanceof App\Response) {
                $response->content = '';
                return $response;
            }
        }
        return null;
    }
}
