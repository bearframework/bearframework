<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * A data driver interface.
 * @codeCoverageIgnore
 */
interface IDataDriver
{

    /**
     * Stores a data item.
     * 
     * @param \BearFramework\App\DataItem $item The data item to store.
     * @return void No value is returned.
     */
    public function set(DataItem $item): void;

    /**
     * Sets a new value of the item specified or creates a new item with the key and value specified.
     * 
     * @param string $key The key of the data item.
     * @param string $value The value of the data item.
     * @return void No value is returned.
     */
    public function setValue(string $key, string $value): void;

    /**
     * Returns a stored data item or null if not found.
     * 
     * @param string $key The key of the stored data item.
     * @return \BearFramework\App\DataItem|null A data item or null if not found.
     */
    public function get(string $key): ?\BearFramework\App\DataItem;

    /**
     * Returns the value of a stored data item or null if not found.
     * 
     * @param string $key The key of the stored data item.
     * @return string|null The value of a stored data item or null if not found.
     */
    public function getValue(string $key): ?string;

    /**
     * Returns TRUE if the data item exists. FALSE otherwise.
     * 
     * @param string $key The key of the stored data item.
     * @return bool TRUE if the data item exists. FALSE otherwise.
     */
    public function exists(string $key): bool;

    /**
     * Appends data to the data item's value specified. If the data item does not exist, it will be created.
     * 
     * @param string $key The key of the data item.
     * @param string $content The content to append.
     * @return void No value is returned.
     */
    public function append(string $key, string $content): void;

    /**
     * Creates a copy of the data item specified.
     * 
     * @param string $sourceKey The key of the source data item.
     * @param string $destinationKey The key of the destination data item.
     * @return void No value is returned.
     */
    public function duplicate(string $sourceKey, string $destinationKey): void;

    /**
     * Changes the key of the data item specified.
     * 
     * @param string $sourceKey The current key of the data item.
     * @param string $destinationKey The new key of the data item.
     * @return void No value is returned.
     */
    public function rename(string $sourceKey, string $destinationKey): void;

    /**
     * Deletes the data item specified and it's metadata.
     * 
     * @param string $key The key of the data item to delete.
     * @return void No value is returned.
     */
    public function delete(string $key): void;

    /**
     * Stores metadata for the data item specified.
     * 
     * @param string $key The key of the data item.
     * @param string $name The metadata name.
     * @param string $value The metadata value.
     * @return void No value is returned.
     */
    public function setMetadata(string $key, string $name, string $value): void;

    /**
     * Retrieves metadata for the data item specified.
     * 
     * @param string $key The data item key.
     * @param string $name The metadata name.
     * @return string|null The value of the data item metadata.
     */
    public function getMetadata(string $key, string $name): ?string;

    /**
     * Deletes metadata for the data item key specified.
     * 
     * @param string $key The data item key.
     * @param string $name The metadata name.
     * @return void No value is returned.
     */
    public function deleteMetadata(string $key, string $name): void;

    /**
     * Returns a list of all data item's metadata.
     * 
     * @param string $key The data item key.
     * @return \BearFramework\DataList A list containing the metadata for the data item specified.
     */
    public function getMetadataList(string $key): \BearFramework\DataList;

    /**
     * Returns a list of all items in the data storage.
     * 
     * @param \BearFramework\DataListContext $context
     * @return \BearFramework\DataList|\BearFramework\App\DataItem[] A list of all items in the data storage.
     */
    public function getList(\IvoPetkov\DataListContext $context): \BearFramework\DataList;

    /**
     * Returns a DataItemStreamWrapper for the key specified.
     * 
     * @param string $key The data item key.
     * @return \BearFramework\App\IDataItemStreamWrapper
     */
    public function getDataItemStreamWrapper(string $key): \BearFramework\App\IDataItemStreamWrapper;
}
