<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * @runTestsInSeparateProcesses
 */
class DataTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testAll()
    {
        $app = $this->getApp();

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

    /**
     * 
     */
    public function testExeccute()
    {
        $app = $this->getApp();
        $result = $app->data->execute([
            [
                'command' => 'set',
                'key' => 'products/1',
                'body' => '{"name":"Product 1"}'
            ],
            [
                'command' => 'set',
                'key' => 'products/2',
                'body' => '{"name":"Product 2"}'
            ],
            [
                'command' => 'get',
                'key' => 'products/1',
                'result' => ['body']
            ]
        ]);
        $this->assertTrue($result[0] === true);
        $this->assertTrue($result[1] === true);
        $this->assertTrue($result[2] === array(
            'body' => '{"name":"Product 1"}'
        ));
    }

    /**
     * 
     */
    public function testFileName()
    {
        $app = $this->getApp();
        $this->assertTrue($app->data->getFilename('test/key') === $app->config->dataDir . 'objects/test/key');
    }

    /**
     * 
     */
    public function testFileNameInvalidArguments1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->data->getFilename(1);
    }

    /**
     * 
     */
    public function testFileNameInvalidArguments2()
    {
        $app = $this->getApp([
            'dataDir' => null
        ]);

        $this->setExpectedException('\BearFramework\App\InvalidConfigOptionException');
        $app->data->getFilename('key');
    }

    /**
     * 
     */
    public function testFileNameInvalidArguments3()
    {
        $app = $this->getApp([
            'dataDir' => null
        ]);

        $this->setExpectedException('\BearFramework\App\InvalidConfigOptionException');
        $app->data->get([
            'key' => 'users/1',
            'result' => ['body', 'metadata']
        ]);
    }

    /**
     * 
     */
    public function testMakePublicInvalidArguments1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->data->makePublic(1);
    }

    /**
     * 
     */
    public function testMakePrivateInvalidArguments1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->data->makePrivate(1);
    }

    /**
     * 
     */
    public function testIsPublicInvalidArguments1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->data->isPublic(1);
    }

}
