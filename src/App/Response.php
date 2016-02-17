<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Response object
 */
class Response
{

    /**
     * The content of the response
     * @var string 
     */
    public $content = '';

    /**
     * The headers of the response
     * @var array 
     */
    public $headers = [];

    /**
     * The constructor
     * @param string $content The content of the response
     * @throws \InvalidArgumentException
     */
    public function __construct($content = '')
    {
        if (!is_string($content)) {
            throw new \InvalidArgumentException('The content argument must be of type string');
        }
        $this->headers['cacheControl'] = 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0';
        $this->content = $content;
    }

    /**
     * Sets the max age attribute of the cache-control header
     * @param int $seconds Time in seconds
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function setMaxAge($seconds)
    {
        if (!is_int($seconds) || $seconds < 0) {
            throw new \InvalidArgumentException('The seconds argument must be of type int and non negative');
        }
        $this->headers['cacheControl'] = 'Cache-Control: public, max-age=' . $seconds;
    }

    /**
     * Sets the value of the content type header
     * @param string $mimeType The mimetype of the content type header
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function setContentType($mimeType)
    {
        if (!is_string($mimeType)) {
            throw new \InvalidArgumentException('');
        }
        $this->headers['contentType'] = 'Content-Type: ' . $mimeType;
        if ($mimeType === 'text/html' || $mimeType === 'text/plain' || $mimeType === 'text/json' || $mimeType === 'application/xml' || $mimeType === 'text/xml') {
            $this->headers['contentType'] .= '; charset=UTF-8';
        }
    }

    /**
     * Sets the status code of the response header
     * @param int $code The status code of the response header
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function setStatusCode($code)
    {
        if (!is_int($code)) {
            throw new \InvalidArgumentException('');
        }
        $statusCodes = [];
        $statusCodes[200] = 'OK';
        $statusCodes[201] = 'Created';
        $statusCodes[202] = 'Accepted';
        $statusCodes[203] = 'Non-Authoritative Information';
        $statusCodes[204] = 'No Content';
        $statusCodes[205] = 'Reset Content';
        $statusCodes[206] = 'Partial Content';
        $statusCodes[300] = 'Multiple Choices';
        $statusCodes[301] = 'Moved Permanently';
        $statusCodes[302] = 'Found';
        $statusCodes[303] = 'See Other';
        $statusCodes[304] = 'Not Modified';
        $statusCodes[305] = 'Use Proxy';
        $statusCodes[307] = 'Temporary Redirect';
        $statusCodes[400] = 'Bad Request';
        $statusCodes[401] = 'Unauthorized';
        $statusCodes[402] = 'Payment Required';
        $statusCodes[403] = 'Forbidden';
        $statusCodes[404] = 'Not Found';
        $statusCodes[405] = 'Method Not Allowed';
        $statusCodes[406] = 'Not Acceptable';
        $statusCodes[407] = 'Proxy Authentication Required';
        $statusCodes[408] = 'Request Timeout';
        $statusCodes[409] = 'Conflict';
        $statusCodes[410] = 'Gone';
        $statusCodes[411] = 'Length Required';
        $statusCodes[412] = 'Precondition Failed';
        $statusCodes[413] = 'Request Entity Too Large';
        $statusCodes[414] = 'Request-URI Too Long';
        $statusCodes[415] = 'Unsupported Media Type';
        $statusCodes[416] = 'Requested Range Not Satisfiable';
        $statusCodes[417] = 'Expectation Failed';
        $statusCodes[500] = 'Internal Server Error';
        $statusCodes[501] = 'Not Implemented';
        $statusCodes[502] = 'Bad Gateway';
        $statusCodes[503] = 'Service Unavailable';
        $statusCodes[504] = 'Gateway Timeout';
        $statusCodes[505] = 'HTTP Version Not Supported';
        if (!isset($statusCodes[$code])) {
            throw new \InvalidArgumentException('');
        }
        $this->headers['statusCode'] = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1') . ' ' . $code . ' ' . $statusCodes[$code];
    }

}
