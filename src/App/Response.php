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
 * Response object
 * 
 * @property string $content The content of the response
 * @property string $statusCode The response status code
 * @property string $charset The response character set
 * @property \BearFramework\App\Response\Headers $headers The response headers
 * @property \BearFramework\App\Response\Cookies $cookies The response cookies
 */
class Response
{

    use \BearFramework\App\DynamicProperties;

    /**
     * The constructor
     * 
     * @param string $content The content of the response
     * @throws \InvalidArgumentException
     */
    public function __construct($content = '')
    {
        if (!is_string($content)) {
            throw new \InvalidArgumentException('The content argument must be of type string');
        }

        $this->content = $content;

        $this->defineProperty('content', [
            'init' => function() {
                return '';
            },
            'set' => function($value) {
                if (!is_string($value)) {
                    throw new \Exception('The content property value must be of type string');
                }
                return $value;
            },
            'unset' => function() {
                return '';
            }
        ]);
        $this->defineProperty('statusCode', [
            'init' => function() {
                return 200;
            },
            'set' => function($value) {
                if (!is_int($value) && $value !== null) {
                    throw new \Exception('The statusCode property value must be of type int');
                }
                return $value;
            },
            'unset' => function() {
                return null;
            }
        ]);
        $this->defineProperty('charset', [
            'init' => function() {
                return '';
            },
            'set' => function($value) {
                if (!is_string($value)) {
                    throw new \Exception('The charset property value must be of type string');
                }
                return $value;
            },
            'unset' => function() {
                return '';
            }
        ]);
        $this->defineProperty('headers', [
            'init' => function() {
                return new App\Response\Headers();
            },
            'readonly' => true
        ]);
        $this->defineProperty('cookies', [
            'init' => function() {
                return new App\Response\Cookies();
            },
            'readonly' => true
        ]);
    }

}
