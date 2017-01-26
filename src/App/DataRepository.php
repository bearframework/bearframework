<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;
use BearFramework\App\DataItem;
use BearFramework\App\DataList;

/**
 * Data storage
 */
class DataRepository
{

    /**
     * The instance of the data storage library
     * 
     * @var type 
     */
    private $instance = null;
    
    private static $newDataItemCache = null;

    /**
     * Returns the instance of the data storage library
     * 
     * @throws \BearFramework\App\Config\InvalidOptionException
     * @return \IvoPetkov\ObjectStorage The instance of the data storage library
     */
    private function getInstance()
    {
        if ($this->instance === null) {
            $app = App::get();
            if ($app->config->dataDir === null) {
                throw new App\Config\InvalidOptionException('Config option dataDir is not set');
            }
            $this->instance = new \IvoPetkov\ObjectStorage($app->config->dataDir);
        }
        return $this->instance;
    }

    /**
     * 
     * @return \BearFramework\App\DataItem
     */
    public function make(string $key = null, string $value = null): \BearFramework\App\DataItem
    {
        if(self::$newDataItemCache === null){
            self::$newDataItemCache = new \BearFramework\App\DataItem();
        }
        $object = clone(self::$newDataItemCache);
        if ($key !== null) {
            $object->key = $key;
        }
        if ($value !== null) {
            $object->value = $value;
        }
        return $object;
    }
    
    /**
     * Saves data
     */
    public function set(DataItem $item): \BearFramework\App\DataRepository
    {
        $command = [
            'command' => 'set',
            'key' => $item->key,
            'body' => $item->value,
            'metadata.*' => ''
        ];
        $metadata = $item->metadata->toArray();
        foreach ($metadata as $name => $value) {
            $command['metadata.' . $name] = $value;
        }
        try {
            $this->execute([$command]);
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        } catch (\IvoPetkov\ObjectStorage\ObjectLockedException $e) {
            throw new \BearFramework\App\Data\DataLockedException($e->getMessage());
        }
        return $this;
    }

    public function setValue(string $key, string $value): \BearFramework\App\DataRepository
    {
        try {
            $this->execute([
                [
                    'command' => 'set',
                    'key' => $key,
                    'body' => $value
                ]
            ]);
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        } catch (\IvoPetkov\ObjectStorage\ObjectLockedException $e) {
            throw new \BearFramework\App\Data\DataLockedException($e->getMessage());
        }
        return $this;
    }

    public function get(string $key): ?\BearFramework\App\DataItem
    {
        try {
            $result = $this->execute([
                [
                    'command' => 'get',
                    'key' => $key,
                    'result' => ['key', 'body', 'metadata']
                ]
            ]);
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        }
        if (isset($result[0]['key'])) {
            return $this->makeDataItemFromRawData($result[0]);
        }
        return null;
    }

    public function getValue(string $key): ?string
    {
        try {
            $result = $this->execute([
                [
                    'command' => 'get',
                    'key' => $key,
                    'result' => ['body']
                ]
            ]);
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        }
        if (isset($result[0]['body'])) {
            return $result[0]['body'];
        }
        return null;
    }

    /**
     * Returns TRUE if the object exists. FALSE otherwise.
     * @param string $key The key
     * @return bool TRUE if the object exists. FALSE otherwise.
     * @throws \Exception
     */
    public function exists(string $key): bool
    {
        try {
            $result = $this->execute([
                [
                    'command' => 'get',
                    'key' => $key,
                    'result' => ['key']
                ]
            ]);
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        }
        return isset($result[0]['key']);
    }

    /**
     * Appends data to the object specified. If the object does not exist, it will be created.
     * 
     * @param string $key The key
     * @param string $content The content to append
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function append(string $key, string $content): \BearFramework\App\DataRepository
    {
        try {
            $this->execute([
                [
                    'command' => 'append',
                    'key' => $key,
                    'body' => $content
                ]
            ]);
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        } catch (\IvoPetkov\ObjectStorage\ObjectLockedException $e) {
            throw new \BearFramework\App\Data\DataLockedException($e->getMessage());
        }
        return $this;
    }

    /**
     * Creates a copy of the object specified
     * 
     * @param string $sourceKey The source key
     * @param string $destinationKey The destination key
     * @return void No value is returned
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function duplicate(string $sourceKey, string $destinationKey): \BearFramework\App\DataRepository
    {
        try {
            $this->execute([
                [
                    'command' => 'duplicate',
                    'sourceKey' => $sourceKey,
                    'targetKey' => $destinationKey
                ]
            ]);
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        } catch (\IvoPetkov\ObjectStorage\ObjectLockedException $e) {
            throw new \BearFramework\App\Data\DataLockedException($e->getMessage());
        }
        return $this;
    }

    /**
     * Changes the key of the object specified
     * 
     * @param string $sourceKey The source key
     * @param string $destinationKey The destination key
     * @return void No value is returned
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function rename(string $sourceKey, string $destinationKey): \BearFramework\App\DataRepository
    {
        try {
            $this->execute([
                [
                    'command' => 'rename',
                    'sourceKey' => $sourceKey,
                    'targetKey' => $destinationKey
                ]
            ]);
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        } catch (\IvoPetkov\ObjectStorage\ObjectLockedException $e) {
            throw new \BearFramework\App\Data\DataLockedException($e->getMessage());
        }
        return $this;
    }

    /**
     * Deletes the object specified and it's metadata
     * 
     * @param string $key The key
     * @return void No value is returned
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function delete(string $key): \BearFramework\App\DataRepository
    {
        try {
            $this->execute([
                [
                    'command' => 'delete',
                    'key' => $key
                ]
            ]);
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        } catch (\IvoPetkov\ObjectStorage\ObjectLockedException $e) {
            throw new \BearFramework\App\Data\DataLockedException($e->getMessage());
        }
        return $this;
    }

    /**
     * Saves metadata for the key specified
     * 
     * @param string $key The key
     * @param string $name The metadata name
     * @param string $value The metadata value
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function setMetadata(string $key, string $name, string $value): \BearFramework\App\DataRepository
    {
        try {
            $this->execute([
                [
                    'command' => 'set',
                    'key' => $key,
                    'metadata.' . $name => $value
                ]
            ]);
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        } catch (\IvoPetkov\ObjectStorage\ObjectLockedException $e) {
            throw new \BearFramework\App\Data\DataLockedException($e->getMessage());
        }
        return $this;
    }

    /**
     * Retrieves metadata for the key specified
     * 
     * @param string $key The key
     * @param string $name The metadata name
     * @return type
     * @throws \Exception
     */
    public function getMetadata(string $key, string $name): ?string
    {
        try {
            $result = $this->execute([
                [
                    'command' => 'get',
                    'key' => $key,
                    'result' => ['metadata.' . $name]
                ]
                    ]
            );
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        }
        return isset($result[0]['metadata.' . $name]) ? $result[0]['metadata.' . $name] : null;
    }

    /**
     * Deletes metadata for the key specified
     * 
     * @param string $key The key
     * @param string $name The metadata name
     */
    public function deleteMetadata(string $key, string $name): \BearFramework\App\DataRepository
    {
        $this->setMetadata($key, $name, '');
        return $this;
    }

    /**
     * Returns a list of all data object's metadata
     * 
     * @param string $key The key
     * @return \IvoPetkov\DataList
     * @throws \Exception
     */
    public function getMetadataList(string $key): \IvoPetkov\DataList
    {
        try {
            $result = $this->execute([
                [
                    'command' => 'get',
                    'key' => $key,
                    'result' => ['metadata']
                ]
                    ]
            );
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        }
        $objectMetadata = [];
        foreach ($result[0] as $name => $value) {
            if (strpos($name, 'metadata.') === 0) {
                $name = substr($name, 9);
                if ($name !== 'internalFrameworkPropertyPublic') {
                    $objectMetadata[] = ['name' => $name, 'value' => $value];
                }
            }
        }
        return new \IvoPetkov\DataList($objectMetadata);
    }

    /**
     * 
     * @return \BearFramework\DataList
     */
    public function getList()
    {
        return new \BearFramework\DataList(function($context) {
            $whereOptions = [];
            foreach ($context->filterByProperties as $filter) {
                $whereOptions[] = [$filter->property, $filter->value, $filter->operator];
            }
            try {
                $result = $this->execute([
                    [
                        'command' => 'search',
                        'where' => $whereOptions,
                        'result' => ['key', 'body', 'metadata']
                    ]
                ]);
            } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
                throw new \Exception($e->getMessage());
            }
            $list = [];
            foreach ($result[0] as $rawData) {
                $list[] = $this->makeDataItemFromRawData($rawData);
            }
            return $list;
        });
    }

    private function makeDataItemFromRawData(array $rawData): \BearFramework\App\DataItem
    {
        $dataItem = $this->make($rawData['key'], $rawData['body']);
        foreach ($rawData as $name => $value) {
            if (strpos($name, 'metadata.') === 0) {
                $name = substr($name, 9);
                if ($name !== 'internalFrameworkPropertyPublic') {
                    $dataItem->metadata->$name = $value;
                }
            }
        }
        return $dataItem;
    }

    /**
     * Executes multiple commands
     * 
     * @param array $commands Commands
     * @return array List of commands results
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    private function execute(array $commands): array
    {
        $instance = $this->getInstance();
        try {
            return $instance->execute($commands);
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        } catch (\IvoPetkov\ObjectStorage\ObjectLockedException $e) {
            throw new \BearFramework\App\Data\DataLockedException($e->getMessage());
        }
    }

    /**
     * Marks object as public so it can be accessed as an asset
     * 
     * @param string $key The key
     * @throws \InvalidArgumentException
     * @return void No value is returned
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function makePublic(string $key): \BearFramework\App\DataRepository
    {
        $this->setMetadata($key, 'internalFrameworkPropertyPublic', '1');
        return $this;
    }

    /**
     * Marks object as private, so it cannot be accessed as an asset
     * 
     * @param string $key The key
     * @throws \InvalidArgumentException
     * @return void No value is returned
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function makePrivate(string $key): \BearFramework\App\DataRepository
    {
        $this->deleteMetadata($key, 'internalFrameworkPropertyPublic');
        return $this;
    }

    /**
     * Checks if an object is marked as public
     * 
     * @param string $key The object key
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @return bool TRUE if public. FALSE otherwise.
     */
    public function isPublic(string $key): bool
    {
        return $this->getMetadata($key, 'internalFrameworkPropertyPublic') === '1';
    }

    /**
     * Checks if an key is valid
     * 
     * @param string $key The key to check
     * @return bool TRUE if valid. FALSE otherwise.
     */
    public function isValidKey(string $key): bool
    {
        $instance = $this->getInstance();
        return $instance->isValidKey($key);
    }

    /**
     * Returns the filename of the object key specified
     * 
     * @param string $key The object key
     * @throws \InvalidArgumentException
     * @throws \BearFramework\App\Config\InvalidOptionException
     * @return string The filename of the object key specified
     */
    public function getFilename(string $key): string
    {
        $app = App::get();
        if ($app->config->dataDir === null) {
            throw new App\Config\InvalidOptionException('Config option dataDir is not set');
        }
        if (!$this->isValidKey($key)) {
            throw new \InvalidArgumentException('The key argument is not valid');
        }
        return $app->config->dataDir . DIRECTORY_SEPARATOR . 'objects' . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $key);
    }

    /**
     * Returns the key name of the object filename specified
     * 
     * @param string $filename The filename
     * @throws \InvalidArgumentException
     * @throws \BearFramework\App\Config\InvalidOptionException
     * @return string The key of the object
     */
//    public function getKeyFromFilename(string $filename): string
//    {
//        $app = App::get();
//        if ($app->config->dataDir === null) {
//            throw new App\Config\InvalidOptionException('Config option dataDir is not set');
//        }
//        $filename = realpath($filename);
//        if ($filename === false) {
//            throw new \InvalidArgumentException('The filename specified does not exist');
//        }
//        if (strpos($filename, $app->config->dataDir . DIRECTORY_SEPARATOR . 'objects' . DIRECTORY_SEPARATOR) === 0) {
//            return substr($filename, strlen($app->config->dataDir . DIRECTORY_SEPARATOR . 'objects' . DIRECTORY_SEPARATOR));
//        }
//        throw new \InvalidArgumentException('The filename specified is not valid data object');
//    }

}
