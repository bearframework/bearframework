<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * Response type that reads file and outputs it.
 * 
 * @property string $filename The filename to output.
 */
class FileReader extends \BearFramework\App\Response
{

    use \IvoPetkov\DataObjectTrait;
    use \IvoPetkov\DataObjectToArrayTrait;
    use \IvoPetkov\DataObjectToJSONTrait;

    /**
     * 
     * @param string $filename The filename to output.
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
                $filename = realpath($value);
                if ($filename === false || !is_readable($filename)) {
                    throw new \InvalidArgumentException('The filename specified (' . $value . ') does not exist or is not readable.');
                }
                return $filename;
            },
            'unset' => function() {
                return '';
            },
        ]);

        if (isset($filename{0})) {
            $this->filename = $filename;
        }
    }

}
