<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * Response type that reads file and outputs it
 * 
 * @property string $filename The filename to output
 */
class FileReader extends \BearFramework\App\Response
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * The constructor 
     * 
     * @param string $filename The filename to output
     * @throws \InvalidArgumentException
     */
    public function __construct(string $filename)
    {
        parent::__construct('');

        $this->defineProperty('filename', [
            'type' => 'string',
            'init' => function() {
                return '';
            },
            'set' => function($value) {
                $value = realpath($value);
                if ($value === false || !is_readable($value)) {
                    throw new \InvalidArgumentException('The filename specified does not exist or is not readable');
                }
                return $value;
            },
            'unset' => function() {
                return '';
            },
        ]);

        $this->filename = $filename;
    }

}
