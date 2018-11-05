<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
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
        $this->assertTrue($app->data->getFilename('test/key') === 'appdata://test/key');
    }

    /**
     * 
     */
    public function testGetFileNameInvalidArguments2()
    {
        $app = $this->getApp();

        $this->expectException('InvalidArgumentException');
        $app->data->getFilename('*');
    }

    /**
     * 
     */
//    public function testGetKeyFromFilenameInvalidArguments2()
//    {
//        $app = $this->getApp();
//        $this->expectException('InvalidArgumentException');
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
//        $this->makeFile($filename, '123');
//        $this->expectException('\BearFramework\App\Config\InvalidOptionException');
//        $app->data->getKeyFromFilename($filename);
//    }

    /**
     * 
     */
//    public function testGetKeyFromFilenameInvalidArguments4()
//    {
//        $app = $this->getApp();
//        $filename = $app->config->appDir . '/file.png';
//        $this->makeFile($filename, '123');
//        $this->expectException('InvalidArgumentException');
//        $app->data->getKeyFromFilename($filename);
//    }

    /**
     * 
     */
//    public function testGetExceptions1()
//    {
//        $app = $this->getApp();
//        $this->makeFile($app->config->dataDir . '/objects', 'data');
//        $this->expectException('\Exception');
//        $app->data->get('data1');
//    }

    /**
     * 
     */
    public function testSetExceptions1()
    {
        $app = $this->getApp();
        $this->makeDir($app->config->dataDir . '/objects/data1');
        $this->expectException('\Exception');
        $app->data->setValue('data1', 'data');
    }

    /**
     * 
     */
    public function testSetExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->expectException('\BearFramework\App\Data\DataLockedException');
        $app->data->setValue('lockeddata1', 'data');
    }

    /**
     * 
     */
    public function testAppendExceptions1()
    {
        $app = $this->getApp();
        $this->makeDir($app->config->dataDir . '/objects/data1');
        $this->expectException('\Exception');
        $app->data->append('data1', 'data');
    }

    /**
     * 
     */
    public function testAppendExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->expectException('\BearFramework\App\Data\DataLockedException');
        $app->data->append('lockeddata1', 'data');
    }

    /**
     * 
     */
    public function testDuplicateExceptions1()
    {
        $app = $this->getApp();
        $app->data->setValue('data1', 'data');
        $this->makeDir($app->config->dataDir . '/objects/data2');
        $this->expectException('\Exception');
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
        $this->expectException('\BearFramework\App\Data\DataLockedException');
        $app->data->duplicate('data1', 'lockeddata2');
    }

    /**
     * 
     */
    public function testRenameExceptions1()
    {
        $app = $this->getApp();
        $app->data->setValue('data1', 'data');
        $this->makeDir($app->config->dataDir . '/objects/data2');
        $this->expectException('\Exception');
        $app->data->rename('data1', 'data2');
    }

    /**
     * 
     */
    public function testRenameExceptions2()
    {
        $app = $this->getApp();
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->expectException('\BearFramework\App\Data\DataLockedException');
        $app->data->rename('lockeddata1', 'data2');
    }

    /**
     * 
     */
    public function testDeleteExceptions2()
    {
        $app = $this->getApp();
        $app->data->setValue('lockeddata1', 'data');
        $this->lockFile($app->config->dataDir . '/objects/lockeddata1');
        $this->expectException('\BearFramework\App\Data\DataLockedException');
        $app->data->delete('lockeddata1');
    }

    /**
     * 
     */
    public function testEvents()
    {
        $app = $this->getApp();

        $changeCount = 0;
        $app->data->addEventListener('itemChange', function(\BearFramework\App\Data\ItemChangeEvent $event) use (&$changeCount) {
            $changeCount++;
        });

        $requestCount = 0;
        $app->data->addEventListener('itemRequest', function(\BearFramework\App\Data\ItemRequestEvent $event) use (&$requestCount) {
            $requestCount++;
        });

        $setDone = false;
        $app->data->addEventListener('itemSet', function(\BearFramework\App\Data\ItemSetEvent $event) use (&$setDone) {
            $this->assertEquals($event->item->key, 'key1');
            $this->assertEquals($event->item->value, 'data1');
            $setDone = true;
        });
        $app->data->set($app->data->make('key1', 'data1'));
        $this->assertTrue($setDone);

        $setMetadataDone = false;
        $app->data->addEventListener('itemSetMetadata', function(\BearFramework\App\Data\ItemSetMetadataEvent $event) use (&$setMetadataDone) {
            $this->assertEquals($event->key, 'key1');
            $this->assertEquals($event->name, 'name1');
            $this->assertEquals($event->value, 'mdata1');
            $setMetadataDone = true;
        });
        $app->data->setMetadata('key1', 'name1', 'mdata1');
        $this->assertTrue($setMetadataDone);

        $getMetadataDone = false;
        $app->data->addEventListener('itemGetMetadata', function(\BearFramework\App\Data\ItemGetMetadataEvent $event) use (&$getMetadataDone) {
            $this->assertEquals($event->key, 'key1');
            $this->assertEquals($event->name, 'name1');
            $this->assertEquals($event->value, 'mdata1');
            $getMetadataDone = true;
        });
        $app->data->getMetadata('key1', 'name1');
        $this->assertTrue($getMetadataDone);

        $deleteMetadataDone = false;
        $app->data->addEventListener('itemDeleteMetadata', function(\BearFramework\App\Data\ItemDeleteMetadataEvent $event) use (&$deleteMetadataDone) {
            $this->assertEquals($event->key, 'key1');
            $this->assertEquals($event->name, 'name1');
            $deleteMetadataDone = true;
        });
        $app->data->deleteMetadata('key1', 'name1');
        $this->assertTrue($deleteMetadataDone);

        $getMetadataListDone = false;
        $app->data->addEventListener('itemGetMetadataList', function(\BearFramework\App\Data\ItemGetMetadataListEvent $event) use (&$getMetadataListDone) {
            $this->assertEquals($event->key, 'key1');
            $this->assertTrue($event->list instanceof \BearFramework\DataList);
            $getMetadataListDone = true;
        });
        $app->data->getMetadataList('key1');
        $this->assertTrue($getMetadataListDone);

        $setValueDone = false;
        $app->data->addEventListener('itemSetValue', function(\BearFramework\App\Data\ItemSetValueEvent $event) use (&$setValueDone) {
            $this->assertEquals($event->key, 'key1');
            $this->assertEquals($event->value, 'data2');
            $setValueDone = true;
        });
        $app->data->setValue('key1', 'data2');
        $this->assertTrue($setValueDone);

        $getDone = false;
        $app->data->addEventListener('itemGet', function(\BearFramework\App\Data\ItemGetEvent $event) use (&$getDone) {
            $this->assertEquals($event->item->key, 'key1');
            $this->assertEquals($event->item->value, 'data2');
            $getDone = true;
        });
        $app->data->get('key1');
        $this->assertTrue($getDone);

        $getValueDone = false;
        $app->data->addEventListener('itemGetValue', function(\BearFramework\App\Data\ItemGetValueEvent $event) use (&$getValueDone) {
            $this->assertEquals($event->key, 'key1');
            $this->assertEquals($event->value, 'data2');
            $getValueDone = true;
        });
        $app->data->getValue('key1');
        $this->assertTrue($getValueDone);

        $appendDone = false;
        $app->data->addEventListener('itemAppend', function(\BearFramework\App\Data\ItemAppendEvent $event) use (&$appendDone) {
            $this->assertEquals($event->key, 'key1');
            $this->assertEquals($event->content, 'data3');
            $appendDone = true;
        });
        $app->data->append('key1', 'data3');
        $this->assertTrue($appendDone);

        $existsDone = false;
        $app->data->addEventListener('itemExists', function(\BearFramework\App\Data\ItemExistsEvent $event) use (&$existsDone) {
            $this->assertEquals($event->key, 'key1');
            $this->assertEquals($event->exists, true);
            $existsDone = true;
        });
        $app->data->exists('key1');
        $this->assertTrue($existsDone);

        $duplicateDone = false;
        $app->data->addEventListener('itemDuplicate', function(\BearFramework\App\Data\ItemDuplicateEvent $event) use (&$duplicateDone) {
            $this->assertEquals($event->sourceKey, 'key1');
            $this->assertEquals($event->destinationKey, 'key2');
            $duplicateDone = true;
        });
        $app->data->duplicate('key1', 'key2');
        $this->assertTrue($duplicateDone);

        $renameDone = false;
        $app->data->addEventListener('itemRename', function(\BearFramework\App\Data\ItemRenameEvent $event) use (&$renameDone) {
            $this->assertEquals($event->sourceKey, 'key2');
            $this->assertEquals($event->destinationKey, 'key3');
            $renameDone = true;
        });
        $app->data->rename('key2', 'key3');
        $this->assertTrue($renameDone);

        $deleteDone = false;
        $app->data->addEventListener('itemDelete', function(\BearFramework\App\Data\ItemDeleteEvent $event) use (&$deleteDone) {
            $this->assertEquals($event->key, 'key1');
            $deleteDone = true;
        });
        $app->data->delete('key1');
        $this->assertTrue($deleteDone);

        $getListDone = false;
        $app->data->addEventListener('getList', function(\BearFramework\App\Data\GetListEvent $event) use (&$getListDone) {
            $this->assertTrue($event->list instanceof \BearFramework\DataList);
            $getListDone = true;
        });
        $app->data->getList();
        $this->assertTrue($getListDone);

        $this->assertEquals($changeCount, 9); // set + setMetadata + deleteMetadata + setValue + append + duplicate + rename*2 + delete
        $this->assertEquals($requestCount, 6); // getMetadata + itemGetMetadataList + get + getValue + exists + duplicate
    }

    /**
     * 
     */
    public function testStreamWrapper()
    {
        $app = $this->getApp();
        $content = str_repeat('abcdefghijklmnopqrstuvwxyz' . PHP_EOL, 1000);

        $generateFilename = function(bool $isAppData, bool $exists) use ($app, $content) {
            if ($isAppData) {
                $key = 'example-files/' . md5(uniqid('', true));
                $filename = $app->data->getFilename($key);
                if ($exists) {
                    $app->data->setValue($key, $content);
                }
            } else {
                $filename = $this->getTempDir() . '/example-files/' . md5(uniqid('', true));
                $dir = pathinfo($filename, PATHINFO_DIRNAME);
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                if ($exists) {
                    file_put_contents($filename, $content);
                }
            }
            return $filename;
        };

        $filenamesToTest = [
            $generateFilename(true, true) => true,
            $generateFilename(true, false) => false,
            $generateFilename(false, true) => true,
            $generateFilename(false, false) => false
        ];

        set_error_handler(function($errorNumber, $errorMessage, $errorFile, $errorLine) {
            throw new \ErrorException($errorMessage, 0, $errorNumber, $errorFile, $errorLine);
        });

        $assertException = function(callable $callable, string $expectedExceptionMessage) {
            $exceptionMessage = null;
            try {
                $callable();
            } catch (\Exception $e) {
                $exceptionMessage = $e->getMessage();
            }
            $this->assertTrue(strpos($exceptionMessage, $expectedExceptionMessage) !== false, $expectedExceptionMessage);
        };

        foreach ($filenamesToTest as $filename => $exists) {

            $fileInfo = new SplFileInfo($filename);

            // file_get_contents
            if ($exists) {
                $this->assertEquals(file_get_contents($filename), $content);
            } else {
                $assertException(function() use ($filename) {
                    file_get_contents($filename);
                }, 'failed to open stream');
            }

            // file
            if ($exists) {
                $this->assertEquals(file($filename, FILE_IGNORE_NEW_LINES), explode(PHP_EOL, trim($content)));
            } else {
                $assertException(function() use ($filename) {
                    file($filename);
                }, 'failed to open stream');
            }

            // is_file
            if ($exists) {
                $this->assertTrue(is_file($filename));
            } else {
                $this->assertFalse(is_file($filename));
            }

            // copy
            if ($exists) {
                $this->assertTrue(copy($filename, $filename . '_copy'));
                $this->assertEquals(file_get_contents($filename . '_copy'), $content);
            } else {
                $assertException(function() use ($filename) {
                    copy($filename, $filename . '_copy');
                }, 'failed to open stream');
            }

            // fileperms
            if ($exists) {
                $this->assertTrue(is_numeric(fileperms($filename)));
                $this->assertTrue(is_numeric($fileInfo->getPerms()));
            } else {
                $assertException(function() use ($filename) {
                    fileperms($filename);
                }, 'stat failed for');
                $assertException(function() use ($fileInfo) {
                    $fileInfo->getPerms();
                }, 'stat failed for');
            }

            // fileinode 
            if ($exists) {
                $this->assertTrue(is_numeric(fileinode($filename)));
                $this->assertTrue(is_numeric($fileInfo->getInode()));
            } else {
                $assertException(function() use ($filename) {
                    fileinode($filename);
                }, 'stat failed for');
                $assertException(function() use ($fileInfo) {
                    $fileInfo->getInode();
                }, 'stat failed for');
            }

            // filesize 
            if ($exists) {
                $this->assertEquals(filesize($filename), strlen($content));
                $this->assertEquals($fileInfo->getSize(), strlen($content));
            } else {
                $assertException(function() use ($filename) {
                    filesize($filename);
                }, 'stat failed for');
                $assertException(function() use ($fileInfo) {
                    $fileInfo->getSize();
                }, 'stat failed for');
            }

            // fileowner 
            if ($exists) {
                $this->assertTrue(is_numeric(fileowner($filename)));
                $this->assertTrue(is_numeric($fileInfo->getOwner()));
            } else {
                $assertException(function() use ($filename) {
                    fileowner($filename);
                }, 'stat failed for');
                $assertException(function() use ($fileInfo) {
                    $fileInfo->getOwner();
                }, 'stat failed for');
            }

            // filegroup 
            if ($exists) {
                $this->assertTrue(is_numeric(filegroup($filename)));
                $this->assertTrue(is_numeric($fileInfo->getGroup()));
            } else {
                $assertException(function() use ($filename) {
                    filegroup($filename);
                }, 'stat failed for');
                $assertException(function() use ($fileInfo) {
                    $fileInfo->getGroup();
                }, 'stat failed for');
            }

            // fileatime
            if ($exists) {
                $this->assertTrue(is_numeric(fileatime($filename)));
                $this->assertTrue(is_numeric($fileInfo->getATime()));
            } else {
                $assertException(function() use ($filename) {
                    fileatime($filename);
                }, 'stat failed for');
                $assertException(function() use ($fileInfo) {
                    $fileInfo->getATime();
                }, 'stat failed for');
            }

            // filemtime 
            if ($exists) {
                $this->assertTrue(is_numeric(filemtime($filename)));
                $this->assertTrue(is_numeric($fileInfo->getMTime()));
            } else {
                $assertException(function() use ($filename) {
                    filemtime($filename);
                }, 'stat failed for');
                $assertException(function() use ($fileInfo) {
                    $fileInfo->getMTime();
                }, 'stat failed for');
            }

            // filectime 
            if ($exists) {
                $this->assertTrue(is_numeric(filectime($filename)));
                $this->assertTrue(is_numeric($fileInfo->getCTime()));
            } else {
                $assertException(function() use ($filename) {
                    filectime($filename);
                }, 'stat failed for');
                $assertException(function() use ($fileInfo) {
                    $fileInfo->getCTime();
                }, 'stat failed for');
            }

            // filetype 
            if ($exists) {
                $this->assertEquals(filetype($filename), 'file');
                $this->assertEquals($fileInfo->getType(), 'file');
            } else {
                $assertException(function() use ($filename) {
                    filetype($filename);
                }, 'stat failed for');
                $assertException(function() use ($fileInfo) {
                    $fileInfo->getType();
                }, 'stat failed for');
            }

            // is_writable 
            if ($exists) {
                $this->assertTrue(is_writable($filename));
                $this->assertTrue($fileInfo->isWritable());
            } else {
                $this->assertFalse(is_writable($filename));
                $this->assertFalse($fileInfo->isWritable());
            }

            // is_readable 
            if ($exists) {
                $this->assertTrue(is_readable($filename));
                $this->assertTrue($fileInfo->isReadable());
            } else {
                $this->assertFalse(is_readable($filename));
                $this->assertFalse($fileInfo->isReadable());
            }

            // is_executable 
            $this->assertFalse(is_executable($filename));
            $this->assertFalse($fileInfo->isExecutable());

            // is_file 
            if ($exists) {
                $this->assertTrue(is_file($filename));
                $this->assertTrue($fileInfo->isFile());
            } else {
                $this->assertFalse(is_file($filename));
                $this->assertFalse($fileInfo->isFile());
            }

            // is_dir 
            $this->assertFalse(is_dir($filename));
            $this->assertFalse($fileInfo->isDir());

            // is_link
            $this->assertFalse(is_link($filename));
            $this->assertFalse($fileInfo->isLink());

            // file_exists 
            if ($exists) {
                $this->assertTrue(file_exists($filename));
            } else {
                $this->assertFalse(file_exists($filename));
            }

            // lstat 
            if ($exists) {
                $this->assertTrue(is_array(lstat($filename)));
            } else {
                $assertException(function() use ($filename) {
                    lstat($filename);
                }, 'stat failed for');
            }

            // stat 
            if ($exists) {
                $this->assertTrue(is_array(stat($filename)));
            } else {
                $assertException(function() use ($filename) {
                    stat($filename);
                }, 'stat failed for');
            }

            // readfile
            if ($exists) {
                ob_start();
                readfile($filename);
                $result = ob_get_clean();
                $this->assertEquals($result, $content);
            } else {
                $assertException(function() use ($filename) {
                    readfile($filename);
                }, 'failed to open stream');
            }

            // clearstatcache - expect no error
            clearstatcache(true, $filename);
            clearstatcache(false, $filename);

            // fstat
            $handle = fopen($filename . '_temp1', 'c+b');
            $this->assertTrue(is_array(fstat($handle)));
            fclose($handle);
        }

        // chmod
        $this->assertFalse(chmod($generateFilename(true, true), 0777));
        $this->assertFalse(chmod($generateFilename(true, false), 0777));

        // chown
        $this->assertFalse(chown($generateFilename(true, true), 'user'));
        $this->assertFalse(chown($generateFilename(true, false), 'user'));

        // chgrp
        $this->assertFalse(chgrp($generateFilename(true, true), 'group'));
        $this->assertFalse(chgrp($generateFilename(true, false), 'group'));

        // realpath
        $this->assertFalse(realpath($generateFilename(true, true)));
        $this->assertFalse(realpath($generateFilename(true, false)));

        // touch
        $this->assertFalse(touch($generateFilename(true, true)));
        $this->assertFalse(touch($generateFilename(true, false)));

        // fpassthru
        $handle = fopen($generateFilename(true, true), 'rb');
        fseek($handle, 5, SEEK_SET);
        ob_start();
        $charactersCount = fpassthru($handle);
        $result = ob_get_clean();
        $this->assertEquals($charactersCount, strlen($content) - 5);
        $this->assertEquals($result, substr($content, 5));
        fclose($handle);

        // file_put_contents
        $filename = $generateFilename(true, false);
        file_put_contents($filename, $content . $content);
        $this->assertEquals($app->data->getValue(str_replace('appdata://', '', $filename)), $content . $content);

        // rename
        $filename1 = $generateFilename(true, true);
        $filename2 = $generateFilename(true, false);
        $this->assertTrue(is_file($filename1));
        $this->assertFalse(is_file($filename2));
        rename($filename1, $filename2);
        $this->assertFalse(is_file($filename1));
        $this->assertTrue(is_file($filename2));
        $this->assertEquals($app->data->getValue(str_replace('appdata://', '', $filename1)), null);
        $this->assertEquals($app->data->getValue(str_replace('appdata://', '', $filename2)), $content);

        // unlink
        $filename = $generateFilename(true, true);
        $this->assertTrue(is_file($filename));
        $this->assertTrue($app->data->exists(str_replace('appdata://', '', $filename)));
        unlink($filename);
        $this->assertFalse(is_file($filename));
        $this->assertFalse($app->data->exists(str_replace('appdata://', '', $filename)));

        // flock
        $handle = fopen($generateFilename(true, true), 'rb');
        $this->assertFalse(flock($handle, LOCK_EX));
        $this->assertFalse(flock($handle, LOCK_UN));
        fclose($handle);

        // fopen & fclose
        $handle = fopen($generateFilename(true, false), 'wb');
        $this->assertTrue(is_resource($handle));
        $this->assertTrue(fclose($handle));

        // fflush
        $handle = fopen($generateFilename(true, false), 'wb');
        $this->assertEquals(fwrite($handle, 'zzz'), 3);
        $this->assertTrue(fflush($handle));
        fclose($handle);

        // fgetc
        $handle = fopen($generateFilename(true, true), 'rb');
        $this->assertEquals(fgetc($handle), 'a');
        $this->assertEquals(fgetc($handle), 'b');
        fseek($handle, 0, SEEK_END);
        $this->assertFalse(fgetc($handle));
        fclose($handle);

        // fgets
        $handle = fopen($generateFilename(true, true), 'rb');
        $this->assertEquals(fgets($handle), 'abcdefghijklmnopqrstuvwxyz' . PHP_EOL);
        fseek($handle, 0, SEEK_END);
        $this->assertFalse(fgets($handle));
        fclose($handle);

        // fopen, fread, fclose, ftell, fseek, rewind and feof
        $modes = [
            'rb',
            'r+b',
            'wb',
            'w+b',
            'ab',
            'a+b',
            'xb',
            'x+b',
            'cb',
            'c+b',
        ];

        foreach ($modes as $mode) {
            $filenamesToTest = [
                $generateFilename(true, true) => true,
                $generateFilename(true, false) => false,
                $generateFilename(false, true) => true,
                $generateFilename(false, false) => false
            ];
            foreach ($filenamesToTest as $filename => $exists) {

                $thisReadInFileWithContent = function($handle) use ($content) {
                    $this->assertTrue(is_resource($handle));

                    $this->assertTrue(rewind($handle));

                    $this->assertEquals(ftell($handle), 0);
                    $this->assertFalse(feof($handle));

                    for ($i = 0; $i < 2; $i++) {
                        $readContent = '';
                        while (!feof($handle)) {
                            $readContent .= fread($handle, 8192);
                        }
                        $this->assertEquals($readContent, $content);
                        $this->assertEquals(ftell($handle), strlen($content));
                        $this->assertTrue(feof($handle));

                        $this->assertTrue(rewind($handle));
                    }

                    $this->assertEquals(ftell($handle), 0);
                    $this->assertFalse(feof($handle));
                    $this->assertEquals(fread($handle, 3), substr($content, 0, 3));
                    $this->assertEquals(ftell($handle), 3);
                    $this->assertFalse(feof($handle));
                    $this->assertEquals(fread($handle, 3), substr($content, 3, 3));
                    $this->assertEquals(ftell($handle), 6);
                    $this->assertFalse(feof($handle));

                    $this->assertEquals(fseek($handle, 4, SEEK_SET), 0);
                    $this->assertEquals(ftell($handle), 4);
                    $this->assertFalse(feof($handle));
                    $this->assertEquals(fread($handle, 3), substr($content, 4, 3));

                    $this->assertEquals(fseek($handle, 4, SEEK_SET), 0);
                    $this->assertEquals(fseek($handle, 3, SEEK_CUR), 0);
                    $this->assertEquals(ftell($handle), 7);
                    $this->assertFalse(feof($handle));
                    $this->assertEquals(fread($handle, 3), substr($content, 7, 3));

                    $this->assertEquals(fseek($handle, 0, SEEK_END), 0);
                    $this->assertEquals(ftell($handle), strlen($content));
                    fread($handle, 1); // needed by the following feof. why?
                    $this->assertTrue(feof($handle));
                    $this->assertEquals(ftell($handle), strlen($content));

                    $this->assertTrue(rewind($handle));
                };

                $thisReadInFileWithoutContent = function($handle) {
                    $this->assertTrue(rewind($handle));

                    $this->assertEquals(ftell($handle), 0);
                    $this->assertEquals(fseek($handle, 0, SEEK_END), 0);
                    $this->assertEquals(ftell($handle), 0);

                    $this->assertEquals(fwrite($handle, 'zzz'), 3);
                    $this->assertTrue(rewind($handle));
                    $this->assertEquals(fread($handle, 3), 'zzz');

                    $this->assertTrue(rewind($handle));

                    $readContent = '';
                    while (!feof($handle)) {
                        $readContent .= fread($handle, 8192);
                    }
                    $this->assertEquals($readContent, 'zzz');

                    $this->assertEquals(fseek($handle, 0, SEEK_SET), 0);
                    $this->assertTrue(ftruncate($handle, 0));

                    $this->assertEquals(ftell($handle), 0);
                    $this->assertEquals(fseek($handle, 0, SEEK_END), 0);
                    $this->assertEquals(ftell($handle), 0);

                    $this->assertTrue(rewind($handle));

                    $readContent = '';
                    while (!feof($handle)) {
                        $readContent .= fread($handle, 8192);
                    }
                    $this->assertEquals($readContent, '');

                    $this->assertTrue(rewind($handle));
                };

                $thisWriteInFileWithContent = function($handle) use ($content) {
                    $this->assertTrue(rewind($handle));

                    $this->assertEquals(fread($handle, 3), substr($content, 0, 3));
                    $this->assertEquals(fwrite($handle, 'zzz'), 3);
                    $this->assertTrue(rewind($handle));
                    $this->assertEquals(fread($handle, 9), substr($content, 0, 3) . 'zzz' . substr($content, 6, 3));

                    $this->assertEquals(fseek($handle, 3, SEEK_SET), 0);
                    $this->assertEquals(fwrite($handle, substr($content, 3, 3)), 3);

                    $this->assertTrue(rewind($handle));

                    $readContent = '';
                    while (!feof($handle)) {
                        $readContent .= fread($handle, 8192);
                    }
                    $this->assertEquals($readContent, $content);

                    $this->assertTrue(rewind($handle));
                };

                $thisWriteInFileWithoutContent = function($handle) {
                    $this->assertTrue(rewind($handle));

                    $this->assertEquals(ftell($handle), 0);
                    $this->assertEquals(fseek($handle, 0, SEEK_END), 0);
                    $this->assertEquals(ftell($handle), 0);

                    $this->assertEquals(fwrite($handle, 'zzz'), 3);
                    $this->assertEquals(fseek($handle, 0, SEEK_END), 0);
                    $this->assertEquals(ftell($handle), 3);

                    $this->assertEquals(fseek($handle, 0, SEEK_SET), 0);
                    $this->assertTrue(ftruncate($handle, 0));

                    $this->assertEquals(ftell($handle), 0);
                    $this->assertEquals(fseek($handle, 0, SEEK_END), 0);
                    $this->assertEquals(ftell($handle), 0);

                    $this->assertTrue(rewind($handle));
                };

                if ($mode === 'rb') { // Open for reading only; place the file pointer at the beginning of the file.
                    if ($exists) {
                        $handle = fopen($filename, $mode);
                        $thisReadInFileWithContent($handle);
                        $this->assertEquals(fwrite($handle, 'zzz'), 0);
                        fclose($handle);
                    } else {
                        $assertException(function() use ($filename, $mode) {
                            fopen($filename, $mode);
                        }, 'failed to open stream');
                    }
                } elseif ($mode === 'r+b') { // Open for reading and writing; place the file pointer at the beginning of the file.
                    if ($exists) {
                        $handle = fopen($filename, $mode);
                        $thisReadInFileWithContent($handle);
                        $thisWriteInFileWithContent($handle);
                        fclose($handle);
                    } else {
                        $assertException(function() use ($filename, $mode) {
                            fopen($filename, $mode);
                        }, 'failed to open stream');
                    }
                } elseif ($mode === 'wb') { // Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it.
                    $handle = fopen($filename, $mode);
                    $thisWriteInFileWithoutContent($handle);
                    fclose($handle);
                } elseif ($mode === 'w+b') { // Open for reading and writing; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it. 
                    $handle = fopen($filename, $mode);
                    $thisReadInFileWithoutContent($handle);
                    $thisWriteInFileWithoutContent($handle);
                    fclose($handle);
                } elseif ($mode === 'ab') { // Open for writing only; place the file pointer at the end of the file. If the file does not exist, attempt to create it. In this mode, fseek() has no effect, writes are always appended.
                    $handle = fopen($filename, $mode);
                    fwrite($handle, 'zzz');
                    fclose($handle);
                    $this->assertEquals(file_get_contents($filename), ($exists ? $content : '') . 'zzz');
                } elseif ($mode === 'a+b') { // Open for reading and writing; place the file pointer at the end of the file. If the file does not exist, attempt to create it. In this mode, fseek() only affects the reading position, writes are always appended. 
                    $handle = fopen($filename, $mode);
                    if ($exists) {
                        $thisReadInFileWithContent($handle);
                    } else {
                        $thisReadInFileWithoutContent($handle);
                    }
                    fwrite($handle, 'zzz');
                    fclose($handle);
                    $this->assertEquals(file_get_contents($filename), ($exists ? $content : '') . 'zzz');
                } elseif ($mode === 'xb') { // Create and open for writing only; place the file pointer at the beginning of the file. If the file already exists, the fopen() call will fail by returning FALSE and generating an error of level E_WARNING. If the file does not exist, attempt to create it. This is equivalent to specifying O_EXCL|O_CREAT flags for the underlying open(2) system call. 
                    if ($exists) {
                        $assertException(function() use ($filename, $mode) {
                            fopen($filename, $mode);
                        }, 'failed to open stream');
                    } else {
                        $handle = fopen($filename, $mode);
                        $thisWriteInFileWithoutContent($handle);
                        fclose($handle);
                    }
                } elseif ($mode === 'w+b') { // Create and open for reading and writing; otherwise it has the same behavior as 'x'.
                    $handle = fopen($filename, $mode);
                    if ($exists) {
                        $thisReadInFileWithContent($handle);
                        $thisWriteInFileWithContent($handle);
                    } else {
                        $thisReadInFileWithoutContent($handle);
                        $thisWriteInFileWithoutContent($handle);
                    }
                    fclose($handle);
                } elseif ($mode === 'cb') { // Open the file for writing only. If the file does not exist, it is created. If it exists, it is neither truncated (as opposed to 'w'), nor the call to this function fails (as is the case with 'x'). The file pointer is positioned on the beginning of the file. This may be useful if it's desired to get an advisory lock (see flock()) before attempting to modify the file, as using 'w' could truncate the file before the lock was obtained (if truncation is desired, ftruncate() can be used after the lock is requested).
                    if ($exists) {
                        $handle = fopen($filename, $mode);
                        fwrite($handle, 'zzz');
                        fclose($handle);
                        $this->assertEquals(file_get_contents($filename), 'zzz' . substr($content, 3));
                    } else {
                        $handle = fopen($filename, $mode);
                        $thisWriteInFileWithoutContent($handle);
                        fclose($handle);
                    }
                } elseif ($mode === 'c+b') { // Open the file for reading and writing; otherwise it has the same behavior as 'c'.
                    $handle = fopen($filename, $mode);
                    if ($exists) {
                        $thisReadInFileWithContent($handle);
                        $thisWriteInFileWithContent($handle);
                    } else {
                        $thisReadInFileWithoutContent($handle);
                        $thisWriteInFileWithoutContent($handle);
                    }
                    fclose($handle);
                }
            }
        }
    }

    /**
     * 
     */
    public function testDirsStreamWrapper()
    {
        $app = $this->getApp();

        $this->assertTrue(is_dir('appdata://'));
        $this->assertTrue(rmdir('appdata://'));
        $this->assertTrue(mkdir('appdata://'));

        $this->assertFalse(is_dir('appdata://aa/bb'));
        $this->assertTrue(rmdir('appdata://aa/bb'));
        $this->assertTrue(mkdir('appdata://aa/bb'));

        $this->assertFalse(is_dir('appdata://aa/bb/'));
        $this->assertTrue(rmdir('appdata://aa/bb/'));
        $this->assertTrue(mkdir('appdata://aa/bb/'));

        $app->data->setValue('aa/bb/cc', '123');
        $app->data->setValue('aa/bb/dd', '124');

        $this->assertTrue(is_dir('appdata://aa/bb/'));
        $this->assertTrue(rmdir('appdata://aa/bb/'));
        $this->assertTrue(mkdir('appdata://aa/bb/'));

        $this->assertEquals(scandir('appdata://aa'), ['.', '..', 'bb/cc', 'bb/dd']);
        $this->assertEquals(scandir('appdata://aa/'), ['.', '..', 'bb/cc', 'bb/dd']);
        $this->assertEquals(scandir('appdata://'), ['.', '..', 'aa/bb/cc', 'aa/bb/dd']);

        $app->data->setValue('aa/bb/ee', '125');
        $this->assertEquals(scandir('appdata://aa'), ['.', '..', 'bb/cc', 'bb/dd', 'bb/ee']);
        $this->assertEquals(scandir('appdata://aa/'), ['.', '..', 'bb/cc', 'bb/dd', 'bb/ee']);
        $this->assertEquals(scandir('appdata://'), ['.', '..', 'aa/bb/cc', 'aa/bb/dd', 'aa/bb/ee']);
    }

}
