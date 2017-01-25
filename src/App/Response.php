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
 * @property ?int $statusCode The response status code
 * @property string $charset The response character set
 * @property-read \BearFramework\App\Response\HeadersRepository $headers The response headers
 * @property-read \BearFramework\App\Response\Cookies $cookies The response cookies
 */
class Response
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * The constructor
     * 
     * @param string $content The content of the response
     */
    public function __construct(string $content = '')
    {
        $this->content = $content;

        $this->defineProperty('content', [
            'type' => 'string',
            'init' => function() {
                return '';
            },
            'unset' => function() {
                return '';
            }
        ]);
        $this->defineProperty('statusCode', [
            'type' => '?int',
            'init' => function() {
                return 200;
            },
            'unset' => function() {
                return null;
            }
        ]);
        $this->defineProperty('charset', [
            'type' => '?string'
        ]);
        $this->defineProperty('headers', [
            'init' => function() {
                return new App\Response\HeadersRepository();
            },
            'readonly' => true
        ]);
        $this->defineProperty('cookies', [
            'init' => function() {
                return new App\Response\CookiesRepository();
            },
            'readonly' => true
        ]);
    }

}
