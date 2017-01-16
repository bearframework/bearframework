<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;
use BearFramework\App\Data\DataList;
use BearFramework\App\Data\DataObject;
use BearFramework\App\Data\DataObjectMetadata;

/**
 * Data storage
 */
class Data
{

    /**
     * The instance of the data storage library
     * 
     * @var type 
     */
    private $instance = null;

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
     * Retrieves object data for specified key
     * 
     * @param string $key The key
     * @param mixed $defaultValue Return value if the data is not found
     * @return \BearFramework\App\Data\DataObject Object containing the data for the key specified
     * @throws \Exception
     */
    public function get(string $key, $defaultValue = null)
    {
        try {
            $result = $this->execute([
                [
                    'command' => 'get',
                    'key' => $key,
                    'result' => ['key', 'body', 'metadata']
                ]
            ]);
            if (isset($result[0]['key'])) {
                return $this->makeDataObjectFromRawData($result[0]);
            }
            return $defaultValue;
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        }
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
            if (isset($result[0]['key'])) {
                return true;
            }
            return false;
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Saves data
     * 
     * @param string $key The key
     * @param string $body The body
     * @return void No value is returned
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function set(string $key, string $body): void
    {
        try {
            $this->execute([
                [
                    'command' => 'set',
                    'key' => $key,
                    'body' => $body
                ]
            ]);
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        } catch (\IvoPetkov\ObjectStorage\ObjectLockedException $e) {
            throw new \BearFramework\App\Data\DataLockedException($e->getMessage());
        }
    }

    /**
     * Appends data to the object specified. If the object does not exist, it will be created.
     * 
     * @param string $key The key
     * @param string $content The content to append
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function append(string $key, string $content): void
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
    public function duplicate(string $sourceKey, string $destinationKey): void
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
    public function rename(string $sourceKey, string $destinationKey): void
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
    }

    /**
     * Deletes the object specified and it's metadata
     * 
     * @param string $key The key
     * @return void No value is returned
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function delete(string $key): void
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
    public function setMetadata(string $key, string $name, string $value): void
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
    }

    /**
     * Retrieves metadata for the key specified
     * 
     * @param string $key The key
     * @param string $name The metadata name
     * @param type $defaultValue Return value if the metadata is not found
     * @return type
     * @throws \Exception
     */
    public function getMetadata(string $key, string $name, $defaultValue = null)
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
        return isset($result[0]['metadata.' . $name]) ? $result[0]['metadata.' . $name] : $defaultValue;
    }

    /**
     * Deletes metadata for the key specified
     * 
     * @param string $key The key
     * @param string $name The metadata name
     */
    public function deleteMetadata(string $key, string $name): void
    {
        $this->setMetadata($key, $name, '');
    }

    /**
     * 
     * @return \BearFramework\App\Data\DataList
     */
    public function getList(): DataList
    {
        return new DataList(function($context) {
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
            foreach ($result[0] as $itemData) {
                $list[] = $this->makeDataObjectFromRawData($itemData);
            }
            return $list;
        });
    }

    /**
     * Searches for items
     * 
     * @param array $parameters Parameters
     * @return array List of all items matching the search criteria
     * @throws \Exception
     */
//    public function search($parameters)
//    {
//        $instance = $this->getInstance();
//        try {
//            return $instance->search($parameters);
//        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
//            throw new \Exception($e->getMessage());
//        }
//    }

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
    public function makePublic(string $key): void
    {
        $this->setMetadata($key, 'internalFrameworkPropertyPublic', '1');
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
    public function makePrivate(string $key): void
    {
        $this->deleteMetadata($key, 'internalFrameworkPropertyPublic');
    }

    /**
     * Checks if an object is marked as public
     * 
     * @param string $key The object key
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @return boolean TRUE if public. FALSE otherwise.
     */
    public function isPublic(string $key): bool
    {
        return $this->getMetadata($key, 'internalFrameworkPropertyPublic') === '1';
    }

    /**
     * Checks if an key is valid
     * 
     * @param string $key The key to check
     * @return boolean TRUE if valid. FALSE otherwise.
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
        if (!is_string($key)) {
            throw new \InvalidArgumentException('The key argument must be of type string');
        }
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
    public function getKeyFromFilename(string $filename): string
    {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('The filename argument must be of type string');
        }
        $app = App::get();
        if ($app->config->dataDir === null) {
            throw new App\Config\InvalidOptionException('Config option dataDir is not set');
        }
        $filename = realpath($filename);
        if ($filename === false) {
            throw new \InvalidArgumentException('The filename specified does not exist');
        }
        if (strpos($filename, $app->config->dataDir . DIRECTORY_SEPARATOR . 'objects' . DIRECTORY_SEPARATOR) === 0) {
            return substr($filename, strlen($app->config->dataDir . DIRECTORY_SEPARATOR . 'objects' . DIRECTORY_SEPARATOR));
        }
        throw new \InvalidArgumentException('The filename specified is not valid data object');
    }

    /**
     * 
     * @param array $rawData
     * @return DataObject
     */
    private function makeDataObjectFromRawData(array $rawData): DataObject
    {
        $metadata = [];
        foreach ($rawData as $name => $value) {
            if (strpos($name, 'metadata.') === 0) {
                $metadata[substr($name, 9)] = $value;
            }
        }
        if (isset($metadata['internalFrameworkPropertyPublic'])) {
            unset($metadata['internalFrameworkPropertyPublic']);
        }
        return new DataObject([
            'key' => $rawData['key'],
            'body' => $rawData['body'],
            'metadata' => new DataObjectMetadata($metadata),
        ]);
    }

}
