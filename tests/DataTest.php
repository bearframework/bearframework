<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * 
 */
class DataTest extends PHPUnit_Framework_TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testAll()
    {
        $app = new App([
            'dataDir' => sys_get_temp_dir() . '/data' . uniqid() . '/'
        ]);

        $result = $app->data->set([
            'key' => 'users/1',
            'body' => '{"name":"John Smith","email":"john@example.com"}',
            'metadata.lastAccessTime' => '1234567890'
        ]);
        $this->assertTrue($result === true);

        $result = $app->data->get([
            'key' => 'users/1',
            'result' => ['body', 'metadata']
        ]);
        $this->assertTrue($result === array(
            'body' => '{"name":"John Smith","email":"john@example.com"}',
            'metadata.lastAccessTime' => '1234567890',
        ));

        $result = $app->data->append([
            'key' => 'visits/ip.log',
            'body' => "123.123.123.123\n"
        ]);
        $this->assertTrue($result === true);

        $result = $app->data->duplicate([
            'sourceKey' => 'users/1',
            'targetKey' => 'users/2'
        ]);
        $this->assertTrue($result === true);

        $result = $app->data->rename([
            'sourceKey' => 'users/2',
            'targetKey' => 'users/3'
        ]);
        $this->assertTrue($result === true);

        $result = $app->data->delete([
            'key' => 'users/3'
        ]);
        $this->assertTrue($result === true);

        $result = $app->data->search([
            'where' => [
                ['key', ['users/1']]
            ],
            'result' => ['key', 'body']
        ]);
        $this->assertTrue($result === array(
            0 =>
            array(
                'key' => 'users/1',
                'body' => '{"name":"John Smith","email":"john@example.com"}',
            ),
        ));

        $result = $app->data->search([
            'where' => [
                ['key', 'users/9']
            ],
            'result' => ['key', 'body']
        ]);
        $this->assertTrue($result === array());

        $result = $app->data->search([
            'where' => [
                ['key', '^users\/', 'regexp']
            ],
            'result' => ['key', 'body']
        ]);
        $this->assertTrue($result === array(
            0 =>
            array(
                'key' => 'users/1',
                'body' => '{"name":"John Smith","email":"john@example.com"}',
            ),
        ));
    }

}
