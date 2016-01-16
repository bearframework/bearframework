<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

class Data extends \ObjectStorage
{

    /**
     * 
     * @global \App $app
     * @param string $key
     * @throws \InvalidArgumentException
     */
    function makePublic($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('');
        }
        global $app;
        $app->data->set(
                [
                    'key' => $key,
                    'metadata.public' => '1'
                ]
        );
    }

    /**
     * 
     * @global \App $app
     * @param string $key
     * @throws \InvalidArgumentException
     */
    function makePrivate($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('');
        }
        global $app;
        $app->data->set(
                [
                    'key' => $key,
                    'metadata.public' => ''
                ]
        );
    }

    /**
     * 
     * @global \App $app
     * @param string $key
     * @return boolean
     * @throws \InvalidArgumentException
     */
    function isPublic($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('');
        }
        global $app;
        $result = $app->data->get(
                [
                    'key' => $key,
                    'result' => ['metadata.public']
                ]
        );
        return isset($result['metadata.public']) && $result['metadata.public'] === '1';
    }

    /**
     * 
     * @global \App $app
     * @param string $key
     * @param array $options
     * @return string
     * @throws \InvalidArgumentException
     */
    function getUrl($key, $options = [])
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('');
        }
        global $app;
        return $app->assets->getUrl($app->config->dataDir . 'objects/' . $key, $options);
    }

}
