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
class RoutesRepository
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
     * @param string|string[] $pattern Path pattern. Can contain "?" (path segment) and "*" (matches everything).
     * @param callable|callable[] $callback Function that is expected to return object of type \BearFramework\App\Response.
     * @param array $options Matching options for methods (GET, HEAD, POST, DELETE, PUT, PATCH, OPTIONS) and protocols (HTTP, HTTPS).
     * @throws \InvalidArgumentException
     * @return self Returns Returns a reference to itself.
     */
    public function add($pattern, $callback, array $options = ['GET']): self
    {
        if (is_string($pattern)) {
            if (!isset($pattern{0})) {
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
                if (!isset($_pattern{0})) {
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
        $this->data[] = [$pattern, $callback, $options];
        return $this;
    }

    /**
     * Finds the matching callback and returns its result.
     * 
     * @param \BearFramework\App\Request $request The request object to match against.
     * @return mixed The result of the matching callback. NULL if none.
     */
    public function getResponse(\BearFramework\App\Request $request)
    {
        $requestPath = (string) $request->path;
        foreach ($this->data as $route) {
            foreach ($route[0] as $pattern) {
                $found = preg_match('/^' . str_replace(['%2F', '%3F', '%2A'], ['\/', '[^\/]+?', '.+?'], urlencode($pattern)) . '$/u', $requestPath) === 1; // symbols: /, ?, *
                if ($found && !empty($route[2])) {
                    $hasMethodOption = false;
                    $isMethodValid = false;
                    $hasSchemeOption = false;
                    $isSchemeValid = false;
                    foreach ($route[2] as $option) {
                        $option = strtolower($option);
                        if ($option === 'get' || $option === 'head' || $option === 'post' || $option === 'delete' || $option === 'put' || $option === 'patch' || $option === 'options') {
                            $hasMethodOption = true;
                            if ($option === strtolower($request->method)) {
                                $isMethodValid = true;
                            }
                        } elseif ($option === 'http' || $option === 'https') {
                            $hasSchemeOption = true;
                            if ($option === strtolower($request->scheme)) {
                                $isSchemeValid = true;
                            }
                        }
                    }
                    if (($hasMethodOption && !$isMethodValid) || ($hasSchemeOption && !$isSchemeValid)) {
                        $found = false;
                    }
                }
                if ($found) {
                    foreach ($route[1] as $callable) {
                        ob_start();
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
            $getRequest = clone($request);
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
