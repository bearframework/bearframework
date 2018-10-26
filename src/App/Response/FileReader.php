<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
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

        $this
                ->defineProperty('filename', [
                    'type' => 'string',
                    'init' => function() {
                        return '';
                    },
                    'set' => function($value) {
                        if (is_file($value) && is_readable($value)) {
                            return $value;
                        }
                        throw new \InvalidArgumentException('The filename specified (' . $value . ') does not exist or is not readable.');
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
