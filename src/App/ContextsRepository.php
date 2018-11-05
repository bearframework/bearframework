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
 * Provides information about your code context (the directory its located).
 */
class ContextsRepository
{

    /**
     *
     * @var array 
     */
    private $dirs = [];

    /**
     *
     * @var array 
     */
    private static $objectsCache = [];

    /**
     * Returns a context object for the filename specified.
     * 
     * @param string|null $filename The filename used to find the context. Will be automatically detected if not provided.
     * @throws \Exception
     * @return \BearFramework\App\Context The context object for the filename specified.
     */
    public function get(string $filename = null): \BearFramework\App\Context
    {
        if ($filename === null) {
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
            if (!isset($trace[0])) {
                throw new \Exception('Connot detect context!');
            }
            $filename = $trace[0]['file'];
        }
        $filename = str_replace('\\', '/', $filename);
        if (isset(self::$objectsCache[$filename])) {
            return clone(self::$objectsCache[$filename]);
        }
        $matchedDir = null;
        foreach ($this->dirs as $dir => $length) {
            if ($dir === $filename . '/' || substr($filename, 0, $length) === $dir) {
                $matchedDir = $dir;
                break;
            }
        }
        if ($matchedDir !== null) {
            if (isset(self::$objectsCache[$matchedDir])) {
                return clone(self::$objectsCache[$matchedDir]);
            }
            self::$objectsCache[$matchedDir] = new App\Context(substr($matchedDir, 0, -1));
            self::$objectsCache[$filename] = clone(self::$objectsCache[$matchedDir]);
            return clone(self::$objectsCache[$matchedDir]);
        }
        throw new \Exception('Connot find context for ' . $filename);
    }

    /**
     * Registers a new context dir.
     * 
     * @param string $dir The context dir.
     * @throws \Exception
     * @return self Returns a reference to itself.
     */
    public function add(string $dir): self
    {
        $dir = rtrim(str_replace('\\', '/', $dir), '\\/') . '/';
        if (!isset($this->dirs[$dir])) {
            $this->dirs[$dir] = strlen($dir);
            arsort($this->dirs);
            $indexFilename = realpath($dir . 'index.php');
            if (is_file($indexFilename)) {
                ob_start();
                try {
                    (static function($__filename) {
                        include $__filename;
                    })($indexFilename);
                    ob_end_clean();
                } catch (\Exception $e) {
                    ob_end_clean();
                    throw $e;
                }
            } else {
                throw new \Exception('Cannot find index.php file in the dir specified (' . $dir . ')!');
            }
        }
        return $this;
    }

}
