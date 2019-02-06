<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * File based data driver
 */
class FileDataDriver implements \BearFramework\App\IDataDriver
{

    /**
     * The instance of the Object Storage library
     * 
     * @var ?\IvoPetkov\ObjectStorage 
     */
    private $objectStorageInstance = null;

    /**
     *
     * @var ?string 
     */
    private $dir = null;

    /**
     *
     * @var ?\BearFramework\App\DataItem 
     */
    private $newDataItemCache = null;

    /**
     * 
     * @param string $dir The directory where the data will be stored.
     */
    public function __construct(string $dir)
    {
        $this->dir = realpath($dir);
        if ($this->dir === false) {
            throw new \Exception('The directory specified is not valid.');
        }
    }

    /**
     * Stores a data item.
     * 
     * @param \BearFramework\App\DataItem $item The data item to store.
     * @return void No value is returned.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function set(DataItem $item): void
    {
        $command = [
            'command' => 'set',
            'key' => $item->key,
            'body' => $item->value,
            'metadata.*' => ''
        ];
        foreach ($item->metadata as $name => $value) {
            $command['metadata.' . $name] = $value;
        }
        $this->execute([$command]);
    }

    /**
     * Sets a new value of the item specified or creates a new item with the key and value specified.
     * 
     * @param string $key The key of the data item.
     * @param string $value The value of the data item.
     * @return void No value is returned.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function setValue(string $key, string $value): void
    {
        $this->execute([
            [
                'command' => 'set',
                'key' => $key,
                'body' => $value
            ]
        ]);
    }

    /**
     * Returns a stored data item or null if not found.
     * 
     * @param string $key The key of the stored data item.
     * @return \BearFramework\App\DataItem|null A data item or null if not found.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function get(string $key): ?\BearFramework\App\DataItem
    {
        $result = $this->execute([
            [
                'command' => 'get',
                'key' => $key,
                'result' => ['key', 'body', 'metadata']
            ]
        ]);
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
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function getValue(string $key): ?string
    {
        $result = $this->execute([
            [
                'command' => 'get',
                'key' => $key,
                'result' => ['body']
            ]
        ]);
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
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function exists(string $key): bool
    {
        $result = $this->execute([
            [
                'command' => 'get',
                'key' => $key,
                'result' => ['key']
            ]
        ]);
        return isset($result[0]['key']);
    }

    /**
     * Appends data to the data item's value specified. If the data item does not exist, it will be created.
     * 
     * @param string $key The key of the data item.
     * @param string $content The content to append.
     * @return void No value is returned.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function append(string $key, string $content): void
    {
        $this->execute([
            [
                'command' => 'append',
                'key' => $key,
                'body' => $content
            ]
        ]);
    }

    /**
     * Creates a copy of the data item specified.
     * 
     * @param string $sourceKey The key of the source data item.
     * @param string $destinationKey The key of the destination data item.
     * @return void No value is returned.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function duplicate(string $sourceKey, string $destinationKey): void
    {
        $this->execute([
            [
                'command' => 'duplicate',
                'sourceKey' => $sourceKey,
                'targetKey' => $destinationKey
            ]
        ]);
    }

    /**
     * Changes the key of the data item specified.
     * 
     * @param string $sourceKey The current key of the data item.
     * @param string $destinationKey The new key of the data item.
     * @return void No value is returned.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function rename(string $sourceKey, string $destinationKey): void
    {
        $this->execute([
            [
                'command' => 'rename',
                'sourceKey' => $sourceKey,
                'targetKey' => $destinationKey
            ]
        ]);
    }

    /**
     * Deletes the data item specified and it's metadata.
     * 
     * @param string $key The key of the data item to delete.
     * @return void No value is returned.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function delete(string $key): void
    {
        $this->execute([
            [
                'command' => 'delete',
                'key' => $key
            ]
        ]);
    }

    /**
     * Stores metadata for the data item specified.
     * 
     * @param string $key The key of the data item.
     * @param string $name The metadata name.
     * @param string $value The metadata value.
     * @return void No value is returned.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function setMetadata(string $key, string $name, string $value): void
    {
        $this->execute([
            [
                'command' => 'set',
                'key' => $key,
                'metadata.' . $name => $value
            ]
        ]);
    }

    /**
     * Retrieves metadata for the data item specified.
     * 
     * @param string $key The data item key.
     * @param string $name The metadata name.
     * @return string|null The value of the data item metadata.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function getMetadata(string $key, string $name): ?string
    {
        $result = $this->execute([
            [
                'command' => 'get',
                'key' => $key,
                'result' => ['metadata.' . $name]
            ]
                ]
        );
        return isset($result[0]['metadata.' . $name]) ? $result[0]['metadata.' . $name] : null;
    }

    /**
     * Deletes metadata for the data item key specified.
     * 
     * @param string $key The data item key.
     * @param string $name The metadata name.
     * @return void No value is returned.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function deleteMetadata(string $key, string $name): void
    {
        $this->execute([
            [
                'command' => 'set',
                'key' => $key,
                'metadata.' . $name => ''
            ]
        ]);
    }

    /**
     * Returns a list of all items in the data storage.
     * 
     * @param \BearFramework\DataList\Context $context
     * @return \BearFramework\DataList|\BearFramework\App\DataItem[] A list of all items in the data storage.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function getList(\BearFramework\DataList\Context $context): \BearFramework\DataList
    {
        $whereOptions = [];
        $resultKeys = [];
        foreach ($context->actions as $action) {
            if ($action instanceof \BearFramework\DataList\FilterByAction) {
                $whereOptions[] = [$action->property, $action->value, $action->operator];
            } elseif ($action instanceof \BearFramework\DataList\SlicePropertiesAction) {
                foreach ($action->properties as $requestedProperty) {
                    if ($requestedProperty === 'value') {
                        $resultKeys[] = 'body';
                    } elseif ($requestedProperty === 'metadata') {
                        $resultKeys[] = 'metadata';
                    }
                }
            }
        }
        $resultKeys = empty($resultKeys) ? ['key', 'body', 'metadata'] : array_unique(array_merge(['key'], $resultKeys));
        $result = $this->execute([
            [
                'command' => 'search',
                'where' => $whereOptions,
                'result' => $resultKeys
            ]
        ]);
        $list = new \BearFramework\DataList();
        foreach ($result[0] as $rawData) {
            $list[] = $this->makeDataItemFromRawData($rawData);
        }
        return $list;
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
            if ($this->objectStorageInstance === null) {
                $this->objectStorageInstance = new \IvoPetkov\ObjectStorage($this->dir);
            }
            return $this->objectStorageInstance->execute($commands);
        } catch (\IvoPetkov\ObjectStorage\ErrorException $e) {
            throw new \Exception($e->getMessage());
        } catch (\IvoPetkov\ObjectStorage\ObjectLockedException $e) {
            throw new \BearFramework\App\Data\DataLockedException($e->getMessage());
        }
    }

    /**
     * 
     * @param array $rawData
     * @return \BearFramework\App\DataItem
     */
    private function makeDataItemFromRawData(array $rawData): \BearFramework\App\DataItem
    {
        if ($this->newDataItemCache === null) {
            $this->newDataItemCache = new \BearFramework\App\DataItem();
        }
        $dataItem = clone($this->newDataItemCache);
        if (isset($rawData['key'])) {
            $dataItem->key = $rawData['key'];
        }
        if (isset($rawData['body'])) {
            $dataItem->value = $rawData['body'];
        }
        foreach ($rawData as $name => $value) {
            if (strpos($name, 'metadata.') === 0) {
                $name = substr($name, 9);
                $dataItem->metadata[$name] = $value;
            }
        }
        return $dataItem;
    }

    /**
     * Returns a DataItemStreamWrapper for the key specified.
     * 
     * @param string $key The data item key.
     * @return \BearFramework\App\IDataItemStreamWrapper
     */
    public function getDataItemStreamWrapper(string $key): \BearFramework\App\IDataItemStreamWrapper
    {
        return new \BearFramework\App\FileDataItemStreamWrapper($key, $this->dir);
    }

}
