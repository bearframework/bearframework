<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\Internal;

/**
 * 
 * @internal
 */
class Utilities
{

    /**
     * 
     */
    static $registeredAddons = [];

    /**
     *
     * @var array 
     */
    static $cache = [];

    /**
     * 
     */
    static function normalizePath(string $path): string
    {
        if ($path === '') {
            return '';
        }
        $cacheKey = 'normalize-path-' . $path;
        if (!isset(self::$cache[$cacheKey])) {
            for ($i = 0; $i < 2; $i++) {
                if (strpos($path, '://') !== false) { // is url
                    $temp = explode('://', $path, 2);
                    $root = $temp[0] . '://';
                    $path = $temp[1];
                    break;
                } elseif ($path[0] === '/') { // is absolute on Linux
                    $root = '/';
                    $path = substr($path, 1);
                    break;
                } elseif (preg_match('/^[A-Za-z]:[\/\\\]/i', $path) === 1) { // is absolute on Windows
                    $root = substr($path, 0, 2) . '/';
                    $path = substr($path, 3);
                    break;
                } else {
                    if ($i === 0) { // is relative
                        $path = getcwd() . '/' . $path;
                    } else {
                        throw new \Exception('Cannot find absolute path for "' . $path . '"!');
                    }
                }
            }
            $path = str_replace('\\', '/', $path);
            for ($i = 0; $i < 100000; $i++) {
                $newPath = str_replace(['/./', '//'], '/', $path);
                if (substr($newPath, 0, 2) === './') {
                    $newPath = substr($newPath, 2);
                }
                if (substr($newPath, -2) === '/.') {
                    $newPath = substr($newPath, 0, -2);
                }
                if ($newPath !== $path) {
                    $path = $newPath;
                } else {
                    break;
                }
            }
            if (strpos($path, '..') !== false) {
                $parts = explode('/', $path);
                $temp = [];
                foreach ($parts as $part) {
                    if ($part === '..') {
                        array_pop($temp);
                    } else {
                        $temp[] = $part;
                    }
                }
                $path = implode('/', $temp);
            }
            $result = $root . $path;
            self::$cache[$cacheKey] = $result;
            self::$cache['normalize-path-' . $result] = $result; // cache to optimize normalizing normalized paths
            return $result;
        }
        return self::$cache[$cacheKey];
    }
}
