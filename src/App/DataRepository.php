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

    /**
     *
     * @var string 
     */
    private $dir = null;

    /**
     * 
     */
    private static $newDataItemCache = null;

    /**
     * 
     * @param string $dir The directory where the data will be stored.
     */
    function __construct(string $dir)
    {
        $dir = realpath($dir);
        if ($dir === false) {
            throw new \Exception('The directory specified is not valid.');
        }
        $this->dir = $dir;
        $this->instance = new \IvoPetkov\ObjectStorage($dir);
    }

    /**
     * Constructs a new data item and returns it.
     * 
     * @var string|null $key The key of the data item.
     * @var string|null $value The value of the data item.
     * @return \BearFramework\App\DataItem Returns a new data item.
     */
    public function make(string $key = null, string $value = null): \BearFramework\App\DataItem
    {
        if (self::$newDataItemCache === null) {
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
     * Stores a data item.
     * 
     * @param \BearFramework\App\DataItem $item The cache item to store.
     * @return \BearFramework\App\DataRepository A reference to itself.
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

    /**
     * Sets a new value of the item specified or creates a new item with the key and value specified.
     * 
     * @var string $key The key of the data item.
     * @var string $value The value of the data item.
     * @return \BearFramework\App\DataRepository A reference to itself.
     */
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

    /**
     * Returns a stored data item or null if not found.
     * 
     * @param string $key The key of the stored data item.
     * @return \BearFramework\App\DataItem|null A data item or null if not found.
     * @throws \Exception
     */
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

    /**
     * Returns the value of a stored data item or null if not found.
     * 
     * @param string $key The key of the stored data item.
     * @return string|null The value of a stored data item or null if not found.
     * @throws \Exception
     */
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
     * Returns TRUE if the data item exists. FALSE otherwise.
     * 
     * @param string $key The key of the stored data item.
     * @return bool TRUE if the data item exists. FALSE otherwise.
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
     * Appends data to the data item's value specified. If the data item does not exist, it will be created.
     * 
     * @param string $key The key of the data item.
     * @param string $content The content to append.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @return \BearFramework\App\DataRepository A reference to itself.
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
     * Creates a copy of the data item specified.
     * 
     * @param string $sourceKey The key of the source data item.
     * @param string $destinationKey The key of the destination data item.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @return \BearFramework\App\DataRepository A reference to itself.
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
     * Changes the key of the data item specified.
     * 
     * @param string $sourceKey The current key of the data item.
     * @param string $destinationKey The new key of the data item.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @return \BearFramework\App\DataRepository A reference to itself.
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
     * Deletes the data item specified and it's metadata.
     * 
     * @param string $key The key of the data item to delete.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @return \BearFramework\App\DataRepository A reference to itself.
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
     * Stores metadata for the data item specified.
     * 
     * @param string $key The key of the data item.
     * @param string $name The metadata name.
     * @param string $value The metadata value.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @return \BearFramework\App\DataRepository A reference to itself.
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
     * Retrieves metadata for the data item specified.
     * 
     * @param string $key The data item key.
     * @param string $name The metadata name.
     * @return string|null The value of the data item metadata.
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
     * Deletes metadata for the data item key specified.
     * 
     * @param string $key The data item key.
     * @param string $name The metadata name.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @return \BearFramework\App\DataRepository A reference to itself.
     */
    public function deleteMetadata(string $key, string $name): \BearFramework\App\DataRepository
    {
        $this->setMetadata($key, $name, '');
        return $this;
    }

    /**
     * Returns a list of all data item's metadata.
     * 
     * @param string $key The data item key.
     * @return \BearFramework\DataList A list containing the metadata for the data item specified.
     * @throws \Exception
     */
    public function getMetadataList(string $key): \BearFramework\DataList
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
        return new \BearFramework\DataList($objectMetadata);
    }

    /**
     * Returns a list of all items in the data storage.
     * 
     * @return \BearFramework\DataList A list of all items in the data storage.
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

    /**
     * Marks a data item as public so it can be accessed as an asset.
     * 
     * @param string $key The key of the data item.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @return \BearFramework\App\DataRepository A reference to itself.
     */
    public function makePublic(string $key): \BearFramework\App\DataRepository
    {
        $this->setMetadata($key, 'internalFrameworkPropertyPublic', '1');
        return $this;
    }

    /**
     * Marks a data item as private, so it cannot be accessed as an asset.
     * 
     * @param string $key The key of the data item.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @return \BearFramework\App\DataRepository A reference to itself.
     */
    public function makePrivate(string $key): \BearFramework\App\DataRepository
    {
        $this->deleteMetadata($key, 'internalFrameworkPropertyPublic');
        return $this;
    }

    /**
     * Checks if a data item is marked as public.
     * 
     * @param string $key The key of the data item.
     * @throws \Exception
     * @return bool TRUE if public. FALSE otherwise.
     */
    public function isPublic(string $key): bool
    {
        return $this->getMetadata($key, 'internalFrameworkPropertyPublic') === '1';
    }

    /**
     * Checks if a data item key is valid.
     * 
     * @param string $key The key of the data item to check.
     * @return bool TRUE if valid. FALSE otherwise.
     */
    public function isValidKey(string $key): bool
    {
        return $this->instance->isValidKey($key);
    }

    /**
     * Returns the filename of the data item specified.
     * 
     * @param string $key The key of the data item.
     * @throws \InvalidArgumentException
     * @return string The filename of the data item specified.
     */
    public function getFilename(string $key): string
    {
        if (!$this->isValidKey($key)) {
            throw new \InvalidArgumentException('The key argument is not valid');
        }
        return $this->dir . DIRECTORY_SEPARATOR . 'objects' . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $key);
    }

    /**
     * 
     * @param array $rawData
     * @return \BearFramework\App\DataItem
     */
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
     * 
     * @param array $commands
     * @return array
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    private function execute(array $commands): array
    {
        try {
            return $this->instance->execute($commands);
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        } catch (\IvoPetkov\ObjectStorage\ObjectLockedException $e) {
            throw new \BearFramework\App\Data\DataLockedException($e->getMessage());
        }
    }

}
