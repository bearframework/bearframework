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
 * Response object.
 * 
 * @property string $content The content of the response.
 * @property int|null $statusCode The response status code.
 * @property string $charset The response character set.
 * @property-read \BearFramework\App\Response\Headers $headers The response headers.
 * @property-read \BearFramework\App\Response\Cookies $cookies The response cookies.
 */
class Response
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $content The content of the response.
     */
    public function __construct(string $content = '')
    {
        $this->content = $content;

        $this
                ->defineProperty('content', [
                    'type' => 'string'
                ])
                ->defineProperty('statusCode', [
                    'type' => '?int',
                    'init' => function() {
                        return 200;
                    },
                    'unset' => function() {
                        return null;
                    }
                ])
                ->defineProperty('charset', [
                    'type' => '?string'
                ])
                ->defineProperty('headers', [
                    'init' => function() {
                        return new App\Response\Headers();
                    },
                    'readonly' => true
                ])
                ->defineProperty('cookies', [
                    'init' => function() {
                        return new App\Response\Cookies();
                    },
                    'readonly' => true
                ])
        ;
    }

}
