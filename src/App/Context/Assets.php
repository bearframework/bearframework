<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Context;

use BearFramework\App;

/**
 * Provides utility functions for assets in the current context.
 */
class Assets
{

    /**
     *
     * @var string 
     */
    private $dir = '';

    /**
     *
     * @var \BearFramework\App\Assets 
     */
    private static $appAssetsReference = null;

    /**
     * 
     * @param string $dir The directory where the current addon or application are located.
     */
    public function __construct(string $dir)
    {
        $this->dir = str_replace('\\', '/', $dir);
        self::$appAssetsReference = App::get()->assets;
    }

    /**
     * Registers a directory that will be publicly accessible relative to the current addon or application location.
     * 
     * @param string $pathname The directory name.
     * @return self Returns a reference to itself.
     */
    public function addDir(string $pathname): self
    {
        self::$appAssetsReference->addDir($this->dir . '/' . $pathname);
        return $this;
    }

    /**
     * Returns a public URL for the specified filename in the current context.
     * 
     * @param string $filename The filename.
     * @param array $options URL options. You can resize the file by providing "width", "height" or both.
     * @return string The URL for the specified filename and options.
     */
    public function getUrl(string $filename, array $options = []): string
    {
        return self::$appAssetsReference->getUrl($this->dir . '/' . $filename, $options);
    }

    /**
     * Returns the content of the file specified in the current context.
     * 
     * @param string $filename The filename.
     * @param array $options List of options. You can resize the file by providing "width", "height" or both. You can specify encoding too (base64 or data-uri).
     * @return string|null The content of the file or null if file does not exists.
     */
    public function getContent(string $filename, array $options = []): ?string
    {
        return self::$appAssetsReference->getContent($this->dir . '/' . $filename, $options);
    }

}
