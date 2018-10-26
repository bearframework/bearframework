<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
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
     *
     * @var ?\BearFramework\App\DataItem 
     */
    private static $newDataItemCache = null;

    /**
     *
     * @var ?\BearFramework\App\IDataDriver  
     */
    private $driver = null;

    /**
     *
     * @var ?string 
     */
    private $filenameProtocol = null;

    /**
     * Constructs a new data repository.
     * 
     * @param array $options Available options: filenameProtocol - a protocol used for working with data items as files.
     * @throws \Exception
     */
    public function __construct(array $options = [])
    {
        if (isset($options['filenameProtocol'])) {
            if (is_string($options['filenameProtocol'])) {
                $this->filenameProtocol = $options['filenameProtocol'];
                if (stream_wrapper_register($this->filenameProtocol, "BearFramework\App\Internal\DataItemStreamWrapper") === false) {
                    throw new \Exception('A filename protocol named ' . $this->filenameProtocol . ' is already defined!');
                }
            }
        }
    }

    /**
     * Enables the file data driver using the directory specified.
     * 
     * @param string $dir The directory used for file storage.
     * @return void No value is returned.
     */
    public function useFileDriver(string $dir): void
    {
        $this->setDriver(new \BearFramework\App\FileDataDriver($dir));
    }

    /**
     * Sets a new data driver.
     * 
     * @param \BearFramework\App\IDataDriver $driver The data driver to use for data storage.
     * @return void No value is returned.
     * @throws \Exception
     */
    public function setDriver(\BearFramework\App\IDataDriver $driver): void
    {
        if ($this->driver !== null) {
            throw new \Exception('A data driver is already set!');
        }
        $this->driver = $driver;
        if ($this->filenameProtocol !== null) {
            $app = App::get();
            \BearFramework\App\Internal\DataItemStreamWrapper::$environment[$this->filenameProtocol] = [$app, $this, $driver];
        }
    }

    /**
     * Returns the data driver.
     * 
     * @return \BearFramework\App\IDataDriver
     * @throws \Exception
     */
    private function getDriver(): \BearFramework\App\IDataDriver
    {
        if ($this->driver !== null) {
            return $this->driver;
        }
        throw new \Exception('No data driver specified! Use useFileDriver() or setDriver() to specify one.');
    }

    /**
     * Constructs a new data item and returns it.
     * 
     * @param string|null $key The key of the data item.
     * @param string|null $value The value of the data item.
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
     * @param \BearFramework\App\DataItem $item The data item to store.
     * @return \BearFramework\App\DataRepository A reference to itself.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function set(DataItem $item): \BearFramework\App\DataRepository
    {
        $app = App::get();
        $hooks = $app->hooks;

        $item = clone($item);
        $preventDefault = false;
        $hooks->execute('dataItemSet', $item, $preventDefault);
        if (!$preventDefault) {
            $driver = $this->getDriver();
            $driver->set($item);
        }
        $hooks->execute('dataItemSetDone', $item);
        $key = $item->key;
        $hooks->execute('dataItemChanged', $key);
        return $this;
    }

    /**
     * Sets a new value of the item specified or creates a new item with the key and value specified.
     * 
     * @param string $key The key of the data item.
     * @param string $value The value of the data item.
     * @return \BearFramework\App\DataRepository A reference to itself.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function setValue(string $key, string $value): \BearFramework\App\DataRepository
    {
        $app = App::get();
        $hooks = $app->hooks;

        $preventDefault = false;
        $hooks->execute('dataItemSetValue', $key, $value, $preventDefault);
        if (!$preventDefault) {
            $driver = $this->getDriver();
            $driver->setValue($key, $value);
        }
        $hooks->execute('dataItemSetValueDone', $key, $value);
        $hooks->execute('dataItemChanged', $key);
        return $this;
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
        $app = App::get();
        $hooks = $app->hooks;

        $item = null;
        $returnValue = null;
        $preventDefault = false;
        $hooks->execute('dataItemGet', $key, $returnValue, $preventDefault);
        if ($returnValue instanceof \BearFramework\App\DataItem) {
            $item = $returnValue;
        } else {
            if (!$preventDefault) {
                $driver = $this->getDriver();
                $item = $driver->get($key);
            }
        }
        $hooks->execute('dataItemGetDone', $key, $item);
        $hooks->execute('dataItemRequested', $key);
        return $item;
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
        $app = App::get();
        $hooks = $app->hooks;

        $value = null;
        $returnValue = null;
        $preventDefault = false;
        $hooks->execute('dataItemGetValue', $key, $returnValue, $preventDefault);
        if ($returnValue !== null) {
            $value = $returnValue;
        } else {
            if (!$preventDefault) {
                $driver = $this->getDriver();
                $value = $driver->getValue($key);
            }
        }
        $hooks->execute('dataItemGetValueDone', $key, $value);
        $hooks->execute('dataItemRequested', $key);
        return $value;
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
        $app = App::get();
        $hooks = $app->hooks;

        $returnValue = null;
        $hooks->execute('dataItemExists', $key, $returnValue);
        if (is_bool($returnValue)) {
            $exists = $returnValue;
        } else {
            $driver = $this->getDriver();
            $exists = $driver->exists($key);
        }

        $hooks->execute('dataItemExistsDone', $key, $exists);
        $hooks->execute('dataItemRequested', $key);
        return $exists;
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
        $app = App::get();
        $hooks = $app->hooks;

        $preventDefault = false;
        $hooks->execute('dataItemAppend', $key, $content, $preventDefault);
        if (!$preventDefault) {
            $driver = $this->getDriver();
            $driver->append($key, $content);
        }
        $hooks->execute('dataItemAppendDone', $key, $content);
        $hooks->execute('dataItemChanged', $key);
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
        $app = App::get();
        $hooks = $app->hooks;

        $preventDefault = false;
        $hooks->execute('dataItemDuplicate', $sourceKey, $destinationKey, $preventDefault);
        if (!$preventDefault) {
            $driver = $this->getDriver();
            $driver->duplicate($sourceKey, $destinationKey);
        }
        $hooks->execute('dataItemDuplicateDone', $sourceKey, $destinationKey);
        $hooks->execute('dataItemChanged', $destinationKey);
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
        $app = App::get();
        $hooks = $app->hooks;

        $preventDefault = false;
        $hooks->execute('dataItemRename', $sourceKey, $destinationKey, $preventDefault);
        if (!$preventDefault) {
            $driver = $this->getDriver();
            $driver->rename($sourceKey, $destinationKey);
        }
        $hooks->execute('dataItemRenameDone', $sourceKey, $destinationKey);
        $hooks->execute('dataItemChanged', $sourceKey);
        $hooks->execute('dataItemChanged', $destinationKey);
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
        $app = App::get();
        $hooks = $app->hooks;

        $preventDefault = false;
        $hooks->execute('dataItemDelete', $key, $preventDefault);
        if (!$preventDefault) {
            $driver = $this->getDriver();
            $driver->delete($key);
        }
        $hooks->execute('dataItemDeleteDone', $key);
        $hooks->execute('dataItemChanged', $key);
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
        $app = App::get();
        $hooks = $app->hooks;

        $preventDefault = false;
        $hooks->execute('dataItemSetMetadata', $key, $name, $value, $preventDefault);
        if (!$preventDefault) {
            $driver = $this->getDriver();
            $driver->setMetadata($key, $name, $value);
        }
        $hooks->execute('dataItemSetMetadataDone', $key, $name, $value);
        $hooks->execute('dataItemChanged', $key);
        return $this;
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
        $app = App::get();
        $hooks = $app->hooks;

        $value = null;
        $returnValue = null;
        $preventDefault = false;
        $hooks->execute('dataItemGetMetadata', $key, $name, $returnValue, $preventDefault);
        if (is_string($returnValue)) {
            $value = $returnValue;
        } else {
            if (!$preventDefault) {
                $driver = $this->getDriver();
                $value = $driver->getMetadata($key, $name);
            }
        }
        $hooks->execute('dataItemGetMetadataDone', $key, $name, $value);
        $hooks->execute('dataItemRequested', $key);
        return $value;
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
        $app = App::get();
        $hooks = $app->hooks;

        $preventDefault = false;
        $hooks->execute('dataItemDeleteMetadata', $key, $name, $preventDefault);
        if (!$preventDefault) {
            $driver = $this->getDriver();
            $driver->deleteMetadata($key, $name);
        }
        $hooks->execute('dataItemDeleteMetadataDone', $key, $name);
        $hooks->execute('dataItemChanged', $key);
        return $this;
    }

    /**
     * Returns a list of all data item's metadata.
     * 
     * @param string $key The data item key.
     * @return \BearFramework\DataList A list containing the metadata for the data item specified.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function getMetadataList(string $key): \BearFramework\DataList
    {
        $app = App::get();
        $hooks = $app->hooks;

        $value = null;
        $returnValue = null;
        $hooks->execute('dataItemGetMetadataList', $key, $returnValue);
        if ($returnValue instanceof \BearFramework\DataList) {
            $value = $returnValue;
        } else {
            $driver = $this->getDriver();
            $value = $driver->getMetadataList($key);
        }
        $hooks->execute('dataItemGetMetadataListDone', $key, $value);
        $hooks->execute('dataItemRequested', $key);
        return $value;
    }

    /**
     * Returns a list of all items in the data storage.
     * 
     * @return \BearFramework\DataList A list of all items in the data storage.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function getList(): \BearFramework\DataList
    {
        $app = App::get();
        $hooks = $app->hooks;

        $returnValue = null;
        $hooks->execute('dataGetList', $returnValue);
        if ($returnValue instanceof \BearFramework\DataList) {
            $value = $returnValue;
        } else {
            $value = new \BearFramework\DataList(function($context) {
                $driver = $this->getDriver();
                return $driver->getList($context);
            });
        }
        $hooks->execute('dataGetListDone', $value);
        $hooks->execute('dataListRequested');
        return $value;
    }

    /**
     * Checks if a data item key is valid.
     * 
     * @param string $key The key of the data item to check.
     * @return bool TRUE if valid. FALSE otherwise.
     */
    public function isValidKey(string $key): bool
    {
        if (strlen($key) === 0 || $key === '.' || $key === '..' || strpos($key, '/../') !== false || strpos($key, '/./') !== false || strpos($key, '/') === 0 || strpos($key, './') === 0 || strpos($key, '../') === 0 || substr($key, -2) === '/.' || substr($key, -3) === '/..' || substr($key, -1) === '/') {
            return false;
        }
        return preg_match("/^[a-z0-9\.\/\-\_]*$/", $key) === 1;
    }

    /**
     * Returns the filename of the data item specified.
     * 
     * @param string $key The key of the data item.
     * @throws \Exception
     * @throws \InvalidArgumentException
     * @return string The filename of the data item specified.
     */
    public function getFilename(string $key): string
    {
        if ($this->filenameProtocol === null) {
            throw new \Exception('No filenameProtocol specified!');
        }
        $app = App::get();
        $hooks = $app->hooks;

        $value = null;
        $returnValue = null;
        $preventDefault = false;
        $hooks->execute('dataItemGetFilename', $key, $returnValue, $preventDefault);
        if ($returnValue !== null) {
            $value = $returnValue;
        } else {
            if (!$preventDefault) {
                if (!$this->isValidKey($key)) {
                    throw new \InvalidArgumentException('The key argument is not valid!');
                }
                $value = $this->filenameProtocol . '://' . $key;
            }
        }
        $hooks->execute('dataItemGetFilenameDone', $key, $value);
        return $value;
    }

}
