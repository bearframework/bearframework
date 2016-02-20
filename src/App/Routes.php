<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;

/**
 * Provides functionality for registering callbacks for specific requests and executing them
 */
class Routes
{

    /**
     * Stores the registed callbacks
     * @var array 
     */
    private $data = [];

    /**
     * Registers a request handler
     * @param string|string[] $pattern Path pattern. Can contain "?" (path part) and "*" (matches everything).
     * @param callable $callback Function that is expected to return object of type \BearFramework\App\Response.
     * @param array $options Matching options for methods (GET, HEAD, POST, DELETE, PUT, PATCH, OPTIONS) and protocols (HTTP, HTTPS).
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function add($pattern, $callback, $options = ['GET'])
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('The callback argument must be of type callable');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('The options argument must be of type array');
        }
        if (is_string($pattern)) {
            $this->data[] = [[$pattern], $callback, $options];
            return;
        } elseif (is_array($pattern)) {
            if (empty($pattern)) {
                throw new \InvalidArgumentException('The route argument must be of type string or array of strings');
            }
            foreach ($pattern as $_pattern) {
                if (!is_string($_pattern)) {
                    throw new \InvalidArgumentException('The route argument must be of type string or array of strings');
                }
            }
            $this->data[] = [$pattern, $callback, $options];
            return;
        }
        throw new \InvalidArgumentException('The route argument must be of type string or array of strings');
    }

    /**
     * Finds the matching callback and returns its result
     * @param \BearFramework\App\Request $request The current request object
     * @return mixed The result of the matching callback. NULL if none.
     */
    public function getResponse($request)
    {
        if (!($request instanceof App\Request)) {
            throw new \InvalidArgumentException('The request argument must be of type \BearFramework\App\Request');
        }
        $requestPath = (string) $request->path;
        foreach ($this->data as $route) {
            foreach ($route[0] as $pattern) {
                $found = preg_match('/^' . str_replace(['/', '?', '*'], ['\/', '[^\/]+?', '.+?'], $pattern) . '$/u', $requestPath) === 1;
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
                    $response = call_user_func($route[1]);
                    if ($response instanceof App\Response) {
                        return $response;
                    } else {
                        // continue searching
                    }
                }
            }
        }
        return null;
    }

}
