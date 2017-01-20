<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Context;

use BearFramework\App;

/**
 * Provides utility functions for assets in the current context
 */
class Assets
{

    /**
     *
     * @var string 
     */
    private $dir = '';

    /**
     * The constructor
     * 
     * @param string $dir The directory where the current addon or application are located 
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function __construct(string $dir)
    {
        $dir = realpath($dir);
        if ($dir === false) {
            throw new \InvalidArgumentException('The dir specified does not exist');
        }
        $this->dir = $dir;
    }

    /**
     * Registers a directory that will be publicly accessible relative to the current addon or application location
     * 
     * @param string $pathname The directory name
     * @return void No value is returned
     */
    public function addDir(string $pathname): void
    {
        $app = App::get();
        $app->assets->addDir($this->dir . DIRECTORY_SEPARATOR . $pathname);
    }

    /**
     * Returns a public URL for the specified filename in the current context
     * 
     * @param string $filename The filename
     * @param array $options URL options. You can resize the file by providing "width", "height" or both.
     * @throws \InvalidArgumentException
     * @return string The URL for the specified filename and options
     */
    public function getUrl(string $filename, array $options = []): string
    {
        $app = App::get();
//        $filename = realpath($this->dir . DIRECTORY_SEPARATOR . $filename);
//        if ($filename === false) {
//            throw new \InvalidArgumentException('The filename specified does not exist');
//        }
        return $app->assets->getUrl($this->dir . DIRECTORY_SEPARATOR . $filename, $options);
    }

    /**
     * Returns the content of the file specified in the current context
     * 
     * @param string $filename The filename
     * @param array $options List of options. You can resize the file by providing "width", "height" or both. You can specify encoding too (base64 or data-uri).
     * @throws \InvalidArgumentException
     * @throws \BearFramework\App\Config\InvalidOptionException
     * @return null|string The content of the file or FALSE if file does not exists
     */
    public function getContent(string $filename, array $options = []): ?string
    {
        $app = App::get();
        return $app->assets->getContent($this->dir . DIRECTORY_SEPARATOR . $filename, $options);
    }

}
