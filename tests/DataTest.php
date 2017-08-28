<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App\DataItem;

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

        //$dataItem = $app->data->make('users/1', '{"name":"John Smith","email":"john@example.com"}');
        $dataItem = $app->data->make('users/1', '{"name":"John Smith","email":"john@example.com"}');
        $dataItem->metadata->lastAccessTime = '1234567890';
        $app->data->set($dataItem);
        $app->data->makePublic('user/1');

        $this->assertTrue($app->data->getValue('users/1') === '{"name":"John Smith","email":"john@example.com"}');
        $this->assertTrue($app->data->getMetadata('users/1', 'lastAccessTime') === '1234567890');
        $this->assertTrue($app->data->exists('users/1'));

        $this->assertTrue($app->data->getValue('users/2') === null);
        $this->assertFalse($app->data->exists('users/2'));

        $app->data->append('visits/ip.log', "123.123.123.123\n");

        $app->data->duplicate('users/1', 'users/2');

        $app->data->rename('users/2', 'users/3');

        $app->data->delete('users/3');

        $result = $app->data->getList()
                ->filterBy('key', 'users/1');
        $this->assertTrue($result->length === 1);
        $this->assertTrue($result[0]->key === 'users/1');
        $this->assertTrue($result[0]->value === '{"name":"John Smith","email":"john@example.com"}');
        $this->assertTrue($result[0]->metadata->lastAccessTime === '1234567890');

        $result = $app->data->getMetadataList('users/1');
        $this->assertTrue($result->length === 1);
        $this->assertTrue($result[0]->name === 'lastAccessTime');
        $this->assertTrue($result[0]->value === '1234567890');

        $result = $app->data->getList()
                ->filterBy('key', 'users/9');
        $this->assertTrue($result->length === 0);

        $result = $app->data->getList()
                ->filterBy('key', '^users\/', 'regExp');
        $this->assertTrue($result->length === 1);
        $this->assertTrue($result[0]->key === 'users/1');
        $this->assertTrue($result[0]->value === '{"name":"John Smith","email":"john@example.com"}');
        $this->assertTrue($result[0]->metadata->lastAccessTime === '1234567890');
    }

    /**
     * 
     */
    public function testGetFileName()
    {
        $app = $this->getApp();
        $app->data->setValue('test/key', '1');
        $this->assertTrue($app->data->getFilename('test/key') === realpath($app->config->dataDir . '/objects/test/key'));
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
//    public function testGetKeyFromFilenameInvalidArguments2()
//    {
//        $app = $this->getApp();
//        $this->setExpectedException('InvalidArgumentException');
//        $app->data->getKeyFromFilename('missing/file');
//    }

    /**
     * 
     */
//    public function testGetKeyFromFilenameInvalidArguments3()
//    {
//        $app = $this->getApp([
//            'dataDir' => null
//        ]);
//        $filename = $app->config->appDir . '/file.png';
//        $this->createFile($filename, '123');
//        $this->setExpectedException('\BearFramework\App\Config\InvalidOptionException');
//        $app->data->getKeyFromFilename($filename);
//    }

    /**
     * 
     */
//    public function testGetKeyFromFilenameInvalidArguments4()
//    {
//        $app = $this->getApp();
//        $filename = $app->config->appDir . '/file.png';
//        $this->createFile($filename, '123');
//        $this->setExpectedException('InvalidArgumentException');
//        $app->data->getKeyFromFilename($filename);
//    }

    /**
     * 
     */
    public function testGetExceptions1()
    {
        $app = $this->getApp();
        $this->createFile($app->config->dataDir . '/objects', 'data');
        $this->setExpectedException('\Exception');
        $app->data->get('data1');
    }

    /**
     * 
     */
    public function testSetExceptions1()
    {
        $app = $this->getApp();
        $this->createDir($app->config->dataDir . '/objects/data1');
        $this->setExpectedException('\Exception');
        $app->data->setValue('data1', 'data');
    }

    /**
     * 
     */
    public function testSetExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->setValue('lockeddata1', 'data');
    }

    /**
     * 
     */
    public function testAppendExceptions1()
    {
        $app = $this->getApp();
        $this->createDir($app->config->dataDir . '/objects/data1');
        $this->setExpectedException('\Exception');
        $app->data->append('data1', 'data');
    }

    /**
     * 
     */
    public function testAppendExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->append('lockeddata1', 'data');
    }

    /**
     * 
     */
    public function testDuplicateExceptions1()
    {
        $app = $this->getApp();
        $app->data->setValue('data1', 'data');
        $this->createDir($app->config->dataDir . '/objects/data2');
        $this->setExpectedException('\Exception');
        $app->data->duplicate('data1', 'data2');
    }

    /**
     * 
     */
    public function testDuplicateExceptions2()
    {
        $app = $this->getApp();
        $app->data->setValue('data1', 'data');
        $this->lockFile($app->config->dataDir . '/objects/lockeddata2');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->duplicate('data1', 'lockeddata2');
    }

    /**
     * 
     */
    public function testRenameExceptions1()
    {
        $app = $this->getApp();
        $app->data->setValue('data1', 'data');
        $this->createDir($app->config->dataDir . '/objects/data2');
        $this->setExpectedException('\Exception');
        $app->data->rename('data1', 'data2');
    }

    /**
     * 
     */
    public function testRenameExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->rename('lockeddata1', 'data2');
    }

    /**
     * 
     */
    public function testDeleteExceptions1()
    {
        $app = $this->getApp();
        $this->createDir($app->config->dataDir . '/objects/data1');
        $this->setExpectedException('\Exception');
        $app->data->delete('data1');
    }

    /**
     * 
     */
    public function testDeleteExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->delete('lockeddata1');
    }

    /**
     * 
     */
    public function testMakePublicExceptions1()
    {
        $app = $this->getApp();
        $this->createDir($app->config->dataDir . '/objects/data1');
        $this->setExpectedException('\Exception');
        $app->data->makePublic('data1');
    }

    /**
     * 
     */
    public function testMakePublicExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->makePublic('lockeddata1');
    }

    /**
     * 
     */
    public function testMakePrivateExceptions1()
    {
        $app = $this->getApp();
        $this->createDir($app->config->dataDir . '/objects/data1');
        $this->setExpectedException('\Exception');
        $app->data->makePrivate('data1');
    }

    /**
     * 
     */
    public function testMakePrivateExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->setExpectedException('\BearFramework\App\Data\DataLockedException');
        $app->data->makePrivate('lockeddata1');
    }

    /**
     * 
     */
    public function testHooks1()
    {
        $app = $this->getApp();

        $lastHookKey = null;
        $lastHookList = null;

        $app->hooks->add('dataItemChanged', function($key) use (&$lastHookKey) {
            $lastHookKey = $key;
        });

        $app->hooks->add('dataItemRequested', function($key) use (&$lastHookKey) {
            $lastHookKey = $key;
        });

        $app->hooks->add('dataListRequested', function() use (&$lastHookList) {
            $lastHookList = 1;
        });

        $dataItem = $app->data->make('key1', 'data1');
        $dataItem->metadata->metaKey1 = 'metaValue1';
        $dataItem->metadata->metaKey2 = 'metaValue2';
        $app->data->set($dataItem);
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->setValue('key1', 'data2');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->append('key1', 'data3');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->duplicate('key1', 'key2');
        $this->assertTrue($lastHookKey === 'key2');

        $app->data->rename('key2', 'key3');
        $this->assertTrue($lastHookKey === 'key3');

        $app->data->setMetadata('key1', 'metaKey3', 'metaValue3');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->deleteMetadata('key1', 'metaKey3');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->exists('key1');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->get('key1');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->getValue('key1');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->getMetadata('key1', 'metaKey1');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->getMetadataList('key1');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->delete('key1');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->exists('key1');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->get('key1');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->getValue('key1');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->getMetadata('key1', 'metaKey1');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->getMetadataList('key1');
        $this->assertTrue($lastHookKey === 'key1');

        $app->data->getList();
        $this->assertTrue($lastHookList === 1);
    }

    /**
     * Prevent defaults
     */
    public function testHooks2()
    {
        $app = $this->getApp();

        $data = [];

        $app->hooks->add('dataItemSet', function(DataItem $item, &$preventDefault) use (&$data) {
            $preventDefault = true;
            $data[$item->key] = clone($item);
        });

        $app->hooks->add('dataItemGet', function(string $key, &$returnValue, &$preventDefault) use (&$data) {
            $preventDefault = true;
            if (isset($data[$key])) {
                $returnValue = clone($data[$key]);
            }
        });

        $app->hooks->add('dataItemGetValue', function(string $key, &$returnValue, &$preventDefault) use (&$data) {
            $preventDefault = true;
            if (isset($data[$key])) {
                $returnValue = $data[$key]->value;
            }
        });

        $app->hooks->add('dataItemExists', function(string $key, &$returnValue) use (&$data) {
            $returnValue = isset($data[$key]);
        });

        $dataItem = $app->data->make('key1', 'data1');
        $app->data->set($dataItem);
        $dataItem = $app->data->get('key1');
        $this->assertTrue($dataItem->key === 'key1');
        $this->assertTrue($dataItem->value === 'data1');
        $this->assertTrue($app->data->getValue('key1') === 'data1');
        $this->assertTrue($app->data->getValue('key2') === null);
        $this->assertTrue($app->data->exists('key1') === true);
        $this->assertTrue($app->data->exists('key2') === false);
    }

}
