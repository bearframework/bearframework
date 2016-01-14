<?php

namespace App;

class Data extends \ObjectStorage
{

    function makePublic($key)
    {
        global $app;
        $app->data->set(
                [
                    'key' => $key,
                    'metadata.public' => '1'
                ]
        );
    }

    function makePrivate($key)
    {
        global $app;
        $app->data->set(
                [
                    'key' => $key,
                    'metadata.public' => ''
                ]
        );
    }

    function isPublic($key)
    {
        global $app;
        $result = $app->data->get(
                [
                    'key' => $key,
                    'result' => ['metadata.public']
                ]
        );
        return isset($result['metadata.public']) && $result['metadata.public'] === '1';
    }

    function getUrl($key, $options = [])
    {
        global $app;
        return $app->assets->getUrl($app->config->dataDir . 'objects/' . $key, $options);
    }

}
