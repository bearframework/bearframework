<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Assets;

/**
 * @property string $filename
 * @property array $list
 * @property ?array $returnValue
 */
class GetDetailsEvent extends \BearFramework\App\Event
{

    /**
     * 
     * @param string $filename
     * @param array $list
     * @param array $returnValue
     */
    public function __construct(string $filename, array $list, array $returnValue)
    {
        parent::__construct('getDetails');
        $this
                ->defineProperty('filename', [
                    'type' => 'string'
                ])
                ->defineProperty('list', [
                    'type' => 'array'
                ])
                ->defineProperty('returnValue', [
                    'type' => 'array'
                ])
        ;
        $this->filename = $filename;
        $this->list = $list;
        $this->returnValue = $returnValue;
    }

}
