<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * A null data driver. No data is stored and no errors are thrown.
 */
class NullDataDriver implements \BearFramework\App\IDataDriver
{

    /**
     * Stores a data item.
     * 
     * @param \BearFramework\App\DataItem $item The data item to store.
     * @return void No value is returned.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function set(\BearFramework\App\DataItem $item): void
    {
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
        return false;
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
        return null;
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
    }

    /**
     * Returns a list of all items in the data storage.
     * 
     * @param \BearFramework\DataList\Context|null $context
     * @return \BearFramework\DataList|\BearFramework\App\DataItem[] A list of all items in the data storage.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function getList(\BearFramework\DataList\Context $context = null): \BearFramework\DataList
    {
        return new \BearFramework\DataList();
    }

    /**
     * Returns a DataItemStreamWrapper for the key specified.
     * 
     * @param string $key The data item key.
     * @return \BearFramework\App\IDataItemStreamWrapper
     */
    public function getDataItemStreamWrapper(string $key): \BearFramework\App\IDataItemStreamWrapper
    {
        return new \BearFramework\App\NullDataItemStreamWrapper();
    }

}
