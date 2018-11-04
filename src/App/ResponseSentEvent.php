<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * @property \BearFramework\App\Response $response
 */
class ResponseSentEvent extends \BearFramework\App\Event
{

    /**
     * 
     * @param \BearFramework\App\Response $response
     */
    public function __construct(\BearFramework\App\Response $response)
    {
        parent::__construct('responseSent');
        $this
                ->defineProperty('response', [
                    'type' => \BearFramework\App\Response::class
        ]);
        $this->response = $response;
    }

}
