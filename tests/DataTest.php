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

        $app->data->set([
            'key' => 'users/1',
            'body' => '{"name":"John Smith","email":"john@example.com"}',
            'metadata.lastAccessTime' => '1234567890'
        ]);

        $result = $app->data->get([
            'key' => 'users/1',
            'result' => ['body', 'metadata']
        ]);
        $this->assertTrue($result === array(
            'body' => '{"name":"John Smith","email":"john@example.com"}',
            'metadata.lastAccessTime' => '1234567890',
        ));

        $app->data->append([
            'key' => 'visits/ip.log',
            'body' => "123.123.123.123\n"
        ]);

        $app->data->duplicate([
            'sourceKey' => 'users/1',
            'targetKey' => 'users/2'
        ]);

        $app->data->rename([
            'sourceKey' => 'users/2',
            'targetKey' => 'users/3'
        ]);

        $app->data->delete([
            'key' => 'users/3'
        ]);

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
    public function testGetFileName()
    {
        $app = $this->getApp();
        $app->data->set([
            'key' => 'test/key',
            'body' => '1'
        ]);
        $this->assertTrue($app->data->getFilename('test/key') === realpath($app->config->dataDir . '/objects/test/key'));
    }

    /**
     * 
     */
    public function testGetFileNameInvalidArguments1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->data->getFilename(1);
    }

    /**
     * 
     */
    public function testGetFileNameInvalidArguments2()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->data->getFilename('*');
    }

    /**
     * 
     */
    public function testGetFileNameInvalidArguments3()
    {
        $app = $this->getApp([
            'dataDir' => null
        ]);
        $this->setExpectedException('\BearFramework\App\Config\InvalidOptionException');
        $app->data->getFilename('key');
    }

    /**
     * 
     */
    public function testGetFileNameInvalidArguments4()
    {
        $app = $this->getApp([
            'dataDir' => null
        ]);

        $this->setExpectedException('\BearFramework\App\Config\InvalidOptionException');
        $app->data->get([
            'key' => 'users/1',
            'result' => ['body', 'metadata']
        ]);
    }

    /**
     * 
     */
    public function testGetKeyFromFilenameInvalidArguments1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->data->getKeyFromFilename(1);
    }

    /**
     * 
     */
    public function testGetKeyFromFilenameInvalidArguments2()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->data->getKeyFromFilename('missing/file');
    }

    /**
     * 
     */
    public function testGetKeyFromFilenameInvalidArguments3()
    {
        $app = $this->getApp([
            'dataDir' => null
        ]);
        $filename = $app->config->appDir . '/file.png';
        $this->createFile($filename, '123');
        $this->setExpectedException('\BearFramework\App\Config\InvalidOptionException');
        $app->data->getKeyFromFilename($filename);
    }

    /**
     * 
     */
    public function testGetKeyFromFilenameInvalidArguments4()
    {
        $app = $this->getApp();
        $filename = $app->config->appDir . '/file.png';
        $this->createFile($filename, '123');
        $this->setExpectedException('InvalidArgumentException');
        $app->data->getKeyFromFilename($filename);
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

    /**
     * 
     */
    public function testGetExceptions1()
    {
        $app = $this->getApp();
        $this->createFile($app->config->dataDir . '/objects', 'data');
        $this->setExpectedException('\Exception');
        $app->data->get(
                [
                    'key' => 'data1'
                ]
        );
    }

    /**
     * 
     */
    public function testSetExceptions1()
    {
        $app = $this->getApp();
        $this->createDir($app->config->dataDir . '/objects/data1');
        $this->setExpectedException('\Exception');
        $app->data->set(
                [
                    'key' => 'data1',
                    'body' => 'data'
                ]
        );
    }

    /**
     * 
     */
    public function testSetExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->set(
                [
                    'key' => 'lockeddata1',
                    'body' => 'data'
                ]
        );
    }

    /**
     * 
     */
    public function testAppendExceptions1()
    {
        $app = $this->getApp();
        $this->createDir($app->config->dataDir . '/objects/data1');
        $this->setExpectedException('\Exception');
        $app->data->append(
                [
                    'key' => 'data1',
                    'body' => 'data'
                ]
        );
    }

    /**
     * 
     */
    public function testAppendExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->append(
                [
                    'key' => 'lockeddata1',
                    'body' => 'data'
                ]
        );
    }

    /**
     * 
     */
    public function testDuplicateExceptions1()
    {
        $app = $this->getApp();
        $app->data->set(
                [
                    'key' => 'data1',
                    'body' => 'data'
                ]
        );
        $this->createDir($app->config->dataDir . '/objects/data2');
        $this->setExpectedException('\Exception');
        $app->data->duplicate(
                [
                    'sourceKey' => 'data1',
                    'targetKey' => 'data2'
                ]
        );
    }

    /**
     * 
     */
    public function testDuplicateExceptions2()
    {
        $app = $this->getApp();
        $app->data->set(
                [
                    'key' => 'data1',
                    'body' => 'data'
                ]
        );
        $this->lockFile($app->config->dataDir . '/objects/lockeddata2');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->duplicate(
                [
                    'sourceKey' => 'data1',
                    'targetKey' => 'lockeddata2'
                ]
        );
    }

    /**
     * 
     */
    public function testRenameExceptions1()
    {
        $app = $this->getApp();
        $app->data->set(
                [
                    'key' => 'data1',
                    'body' => 'data'
                ]
        );
        $this->createDir($app->config->dataDir . '/objects/data2');
        $this->setExpectedException('\Exception');
        $app->data->rename(
                [
                    'sourceKey' => 'data1',
                    'targetKey' => 'data2'
                ]
        );
    }

    /**
     * 
     */
    public function testRenameExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->rename(
                [
                    'sourceKey' => 'lockeddata1',
                    'targetKey' => 'data2'
                ]
        );
    }

    /**
     * 
     */
    public function testDeleteExceptions1()
    {
        $app = $this->getApp();
        $this->createDir($app->config->dataDir . '/objects/data1');
        $this->setExpectedException('\Exception');
        $app->data->delete(
                [
                    'key' => 'data1'
                ]
        );
    }

    /**
     * 
     */
    public function testDeleteExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->delete(
                [
                    'key' => 'lockeddata1'
                ]
        );
    }

    /**
     * 
     */
    public function testSearchExceptions1()
    {
        $app = $this->getApp();
        $this->createFile($app->config->dataDir . '/objects', 'data');
        $this->setExpectedException('\Exception');
        $app->data->search(
                [
                    'where' => [
                        ['key', 'data1']
                    ]
                ]
        );
    }

    /**
     * 
     */
    public function testExecuteExceptions1()
    {
        $app = $this->getApp();
        $this->createDir($app->config->dataDir . '/objects/data1');
        $this->setExpectedException('\Exception');
        $app->data->execute(
                [
                    [
                        'command' => 'set',
                        'key' => 'data1',
                        'body' => 'data'
                    ]
                ]
        );
    }

    /**
     * 
     */
    public function testExecuteExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->execute(
                [
                    [
                        'command' => 'set',
                        'key' => 'lockeddata1',
                        'body' => 'data'
                    ]
                ]
        );
    }

    /**
     * 
     */
    public function testMakePublicExceptions1()
    {
        $app = $this->getApp();
        $this->createDir($app->config->dataDir . '/objects/data1');
        $this->setExpectedException('\Exception');
        $app->data->makePublic(
                [
                    'key' => 'data1'
                ]
        );
    }

    /**
     * 
     */
    public function testMakePublicExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->makePublic(
                [
                    'key' => 'lockeddata1'
                ]
        );
    }

    /**
     * 
     */
    public function testMakePrivateExceptions1()
    {
        $app = $this->getApp();
        $this->createDir($app->config->dataDir . '/objects/data1');
        $this->setExpectedException('\Exception');
        $app->data->makePrivate(
                [
                    'key' => 'data1'
                ]
        );
    }

    /**
     * 
     */
    public function testMakePrivateExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->makePrivate(
                [
                    'key' => 'lockeddata1'
                ]
        );
    }

}
