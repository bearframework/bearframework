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
class MemoryDataDriver implements \BearFramework\App\IDataDriver
{

    /**
     *
     * @var ?\BearFramework\App\DataItem 
     */
    private $newDataItemCache = null;

    /**
     * 
     * @var array
     */
    private $data = [];

    /**
     * Stores a data item.
     * 
     * @param \BearFramework\App\DataItem $item The data item to store.
     * @return void No value is returned.
     */
    public function set(\BearFramework\App\DataItem $item): void
    {
        $this->data[$item->key] = [$item->value, $item->metadata->toArray()];
    }

    /**
     * Sets a new value of the item specified or creates a new item with the key and value specified.
     * 
     * @param string $key The key of the data item.
     * @param string $value The value of the data item.
     * @return void No value is returned.
     */
    public function setValue(string $key, string $value): void
    {
        if (!isset($this->data[$key])) {
            $this->data[$key] = [null, null];
        }
        $this->data[$key][0] = $value;
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
        if (isset($this->data[$key])) {
            return $this->makeDataItemFromRawData($key, $this->data[$key]);
        }
        return null;
    }

    /**
     * Returns the value of a stored data item or null if not found.
     * 
     * @param string $key The key of the stored data item.
     * @return string|null The value of a stored data item or null if not found.
     */
    public function getValue(string $key): ?string
    {
        if (isset($this->data[$key])) {
            return $this->data[$key][0];
        }
        return null;
    }

    /**
     * Returns the value length of a stored data item or null if not found.
     * 
     * @param string $key The key of the stored data item.
     * @return int|null The value length of a stored data item or null if not found.
     */
    public function getValueLength(string $key): ?int
    {
        if (isset($this->data[$key])) {
            return strlen($this->data[$key][0]);
        }
        return null;
    }

    /**
     * Returns a range of the value of a stored data item or null if not found.
     * 
     * @param string $key The key of the stored data item.
     * @param int $start The start of the range.
     * @param int $end The end of the range.
     * @return string|null The value of a stored data item or null if not found.
     */
    public function getValueRange(string $key, int $start, int $end): ?string
    {
        if (isset($this->data[$key])) {
            return $end !== null ? substr($this->data[$key][0], $start, $end - $start) : substr($this->data[$key][0], $start);
        }
        return null;
    }

    /**
     * Returns TRUE if the data item exists. FALSE otherwise.
     * 
     * @param string $key The key of the stored data item.
     * @return bool TRUE if the data item exists. FALSE otherwise.
     */
    public function exists(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Appends data to the data item's value specified. If the data item does not exist, it will be created.
     * 
     * @param string $key The key of the data item.
     * @param string $content The content to append.
     * @return void No value is returned.
     */
    public function append(string $key, string $content): void
    {
        if (!isset($this->data[$key])) {
            $this->data[$key] = ['', null];
        }
        $this->data[$key][0] .= $content;
    }

    /**
     * Creates a copy of the data item specified.
     * 
     * @param string $sourceKey The key of the source data item.
     * @param string $destinationKey The key of the destination data item.
     * @return void No value is returned.
     */
    public function duplicate(string $sourceKey, string $destinationKey): void
    {
        if (isset($this->data[$sourceKey])) {
            $this->data[$destinationKey] = $this->data[$sourceKey];
        }
    }

    /**
     * Changes the key of the data item specified.
     * 
     * @param string $sourceKey The current key of the data item.
     * @param string $destinationKey The new key of the data item.
     */
    public function rename(string $sourceKey, string $destinationKey): void
    {
        if (isset($this->data[$sourceKey])) {
            $this->data[$destinationKey] = $this->data[$sourceKey];
            unset($this->data[$sourceKey]);
        }
    }

    /**
     * Deletes the data item specified and it's metadata.
     * 
     * @param string $key The key of the data item to delete.
     * @return void No value is returned.
     */
    public function delete(string $key): void
    {
        if (isset($this->data[$key])) {
            unset($this->data[$key]);
        }
    }

    /**
     * Stores metadata for the data item specified.
     * 
     * @param string $key The key of the data item.
     * @param string $name The metadata name.
     * @param string $value The metadata value.
     * @return void No value is returned.
     */
    public function setMetadata(string $key, string $name, string $value): void
    {
        if (isset($this->data[$key])) {
            if (!is_array($this->data[$key][1])) {
                $this->data[$key][1] = [];
            }
            $this->data[$key][1][$name] = $value;
        }
    }

    /**
     * Retrieves metadata for the data item specified.
     * 
     * @param string $key The data item key.
     * @param string $name The metadata name.
     * @return string|null The value of the data item metadata.
     */
    public function getMetadata(string $key, string $name): ?string
    {
        if (isset($this->data[$key]) && is_array($this->data[$key][1]) && isset($this->data[$key][1][$name])) {
            return $this->data[$key][1][$name];
        }
        return null;
    }

    /**
     * Deletes metadata for the data item key specified.
     * 
     * @param string $key The data item key.
     * @param string $name The metadata name.
     * @return void No value is returned.
     */
    public function deleteMetadata(string $key, string $name): void
    {
        if (isset($this->data[$key]) && is_array($this->data[$key][1]) && isset($this->data[$key][1][$name])) {
            unset($this->data[$key][1][$name]);
        }
    }

    /**
     * Returns a list of all items in the data storage.
     * 
     * @param \BearFramework\DataList\Context|null $context
     * @return \BearFramework\DataList|\BearFramework\App\DataItem[] A list of all items in the data storage.
     */
    public function getList(\BearFramework\DataList\Context $context = null): \BearFramework\DataList
    {
        $list = new \BearFramework\DataList();
        foreach ($this->data as $key => $itemRawData) {
            $list[] = $this->makeDataItemFromRawData($key, $itemRawData);
        }
        return $list;
    }

    /**
     * 
     * @param string $key
     * @param array $rawData
     * @return \BearFramework\App\DataItem
     */
    private function makeDataItemFromRawData(string $key, array $rawData): \BearFramework\App\DataItem
    {
        if ($this->newDataItemCache === null) {
            $this->newDataItemCache = new \BearFramework\App\DataItem();
        }
        $dataItem = clone ($this->newDataItemCache);
        $dataItem->key = $key;
        $dataItem->value = $rawData[0];
        if (is_array($rawData[1])) {
            foreach ($rawData[1] as $name => $value) {
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
        return new \BearFramework\App\StringDataItemStreamWrapper(
            function () use ($key): ?string {
                return isset($this->data[$key]) ? $this->data[$key] : null;
            },
            function (string $value) use ($key): void {
                $this->data[$key] = $value;
            },
            function () use ($key): bool {
                return isset($this->data[$key]);
            },
            function () use ($key): int {
                return isset($this->data[$key]) ? strlen($this->data[$key]) : 0;
            }
        );
    }
}
