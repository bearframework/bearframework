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
 * @event \BearFramework\App\Data\ItemRequestEvent itemRequest An event dispatched after a data item is requested.
 * @event \BearFramework\App\Data\ItemChangeEvent itemChange An event dispatched after a data item is changed.
 * @event \BearFramework\App\Data\ItemSetEvent itemSet An event dispatched after a data item is added or updated.
 * @event \BearFramework\App\Data\ItemSetValueEvent itemSetValue An event dispatched after the value of a data item is added or updated.
 * @event \BearFramework\App\Data\ItemGetEvent itemGet An event dispatched after a data item is requested.
 * @event \BearFramework\App\Data\ItemGetValueEvent itemGetValue An event dispatched after the value of a data item is requested.
 * @event \BearFramework\App\Data\ItemExistsEvent itemExists An event dispatched after a data item is checked for existence.
 * @event \BearFramework\App\Data\ItemAppendEvent itemAppend An event dispatched after a content is appended to a data value.
 * @event \BearFramework\App\Data\ItemDuplicateEvent itemDuplicate An event dispatched after a data item is duplicated.
 * @event \BearFramework\App\Data\ItemRenameEvent itemRename An event dispatched after a data item is renamed.
 * @event \BearFramework\App\Data\ItemDeleteEvent itemDelete An event dispatched after a data item is deleted.
 * @event \BearFramework\App\Data\ItemSetMetadataEvent itemSetMetadata An event dispatched after a data item metadata is added or updated.
 * @event \BearFramework\App\Data\ItemGetMetadataEvent itemGetMetadata An event dispatched after a data item metadata is requested.
 * @event \BearFramework\App\Data\ItemDeleteMetadataEvent itemDeleteMetadata An event dispatched after a data item metadata is deleted.
 * @event \BearFramework\App\Data\GetListEvent getList An event dispatched after a data items list is requested.
 */
class DataRepository
{

    use \BearFramework\App\EventsTrait;

    /**
     *
     * @var ?\BearFramework\App\DataItem 
     */
    private $newDataItemCache = null;

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
     *
     * @var \BearFramework\App 
     */
    private $app = null;

    /**
     * Constructs a new data repository.
     * 
     * @param \BearFramework\App $app
     * @param array $options Available options: filenameProtocol - a protocol used for working with data items as files.
     * @throws \Exception
     */
    public function __construct(\BearFramework\App $app, array $options = [])
    {
        $this->app = $app;
        if (isset($options['filenameProtocol'])) {
            if (is_string($options['filenameProtocol'])) {
                $this->filenameProtocol = $options['filenameProtocol'];
                if (stream_wrapper_register($this->filenameProtocol, "BearFramework\App\Internal\DataItemStreamWrapper", STREAM_IS_URL) === false) {
                    throw new \Exception('A filename protocol named ' . $this->filenameProtocol . ' is already defined!');
                }
            }
        }
    }

    /**
     * Enables the file data driver using the directory specified.
     * 
     * @param string $dir The directory used for file storage.
     * @return self Returns a reference to itself.
     */
    public function useFileDriver(string $dir): self
    {
        $this->setDriver(new \BearFramework\App\FileDataDriver($dir));
        return $this;
    }

    /**
     * Enables a null data driver. No data is stored and no errors are thrown.
     * 
     * @return self Returns a reference to itself.
     */
    public function useNullDriver(): self
    {
        $this->setDriver(new \BearFramework\App\NullDataDriver());
        return $this;
    }

    /**
     * Sets a new data driver.
     * 
     * @param \BearFramework\App\IDataDriver $driver The data driver to use for data storage.
     * @return self Returns a reference to itself.
     * @throws \Exception
     */
    public function setDriver(\BearFramework\App\IDataDriver $driver): self
    {
        if ($this->driver !== null) {
            throw new \Exception('A data driver is already set!');
        }
        $this->driver = $driver;
        if ($this->filenameProtocol !== null) {
            \BearFramework\App\Internal\DataItemStreamWrapper::$environment[$this->filenameProtocol] = [$this->app, $this, $driver];
        }
        return $this;
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
        if ($this->newDataItemCache === null) {
            $this->newDataItemCache = new \BearFramework\App\DataItem();
        }
        $object = clone($this->newDataItemCache);
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
     * @return self Returns a reference to itself.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function set(DataItem $item): self
    {
        $driver = $this->getDriver();
        $driver->set($item);
        if ($this->hasEventListeners('itemSet')) {
            $this->dispatchEvent('itemSet', new \BearFramework\App\Data\ItemSetEvent(clone($item)));
        }
        if ($this->hasEventListeners('itemChange')) {
            $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEvent($item->key));
        }
        return $this;
    }

    /**
     * Sets a new value of the item specified or creates a new item with the key and value specified.
     * 
     * @param string $key The key of the data item.
     * @param string $value The value of the data item.
     * @return self Returns a reference to itself.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function setValue(string $key, string $value): self
    {
        $driver = $this->getDriver();
        $driver->setValue($key, $value);
        if ($this->hasEventListeners('itemSetValue')) {
            $this->dispatchEvent('itemSetValue', new \BearFramework\App\Data\ItemSetValueEvent($key, $value));
        }
        if ($this->hasEventListeners('itemChange')) {
            $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEvent($key));
        }
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
        $driver = $this->getDriver();
        $item = $driver->get($key);
        if ($this->hasEventListeners('itemGet')) {
            $this->dispatchEvent('itemGet', new \BearFramework\App\Data\ItemGetEvent($key, $item === null ? null : clone($item)));
        }
        if ($this->hasEventListeners('itemRequest')) {
            $this->dispatchEvent('itemRequest', new \BearFramework\App\Data\ItemRequestEvent($key));
        }
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
        $driver = $this->getDriver();
        $value = $driver->getValue($key);
        if ($this->hasEventListeners('itemGetValue')) {
            $this->dispatchEvent('itemGetValue', new \BearFramework\App\Data\ItemGetValueEvent($key, $value));
        }
        if ($this->hasEventListeners('itemRequest')) {
            $this->dispatchEvent('itemRequest', new \BearFramework\App\Data\ItemRequestEvent($key));
        }
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
        $driver = $this->getDriver();
        $exists = $driver->exists($key);
        if ($this->hasEventListeners('itemExists')) {
            $this->dispatchEvent('itemExists', new \BearFramework\App\Data\ItemExistsEvent($key, $exists));
        }
        if ($this->hasEventListeners('itemRequest')) {
            $this->dispatchEvent('itemRequest', new \BearFramework\App\Data\ItemRequestEvent($key));
        }
        return $exists;
    }

    /**
     * Appends data to the data item's value specified. If the data item does not exist, it will be created.
     * 
     * @param string $key The key of the data item.
     * @param string $content The content to append.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @return self Returns a reference to itself.
     */
    public function append(string $key, string $content): self
    {
        $driver = $this->getDriver();
        $driver->append($key, $content);
        if ($this->hasEventListeners('itemAppend')) {
            $this->dispatchEvent('itemAppend', new \BearFramework\App\Data\ItemAppendEvent($key, $content));
        }
        if ($this->hasEventListeners('itemChange')) {
            $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEvent($key));
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
     * @return self Returns a reference to itself.
     */
    public function duplicate(string $sourceKey, string $destinationKey): self
    {
        $driver = $this->getDriver();
        $driver->duplicate($sourceKey, $destinationKey);
        if ($this->hasEventListeners('itemDuplicate')) {
            $this->dispatchEvent('itemDuplicate', new \BearFramework\App\Data\ItemDuplicateEvent($sourceKey, $destinationKey));
        }
        if ($this->hasEventListeners('itemRequest')) {
            $this->dispatchEvent('itemRequest', new \BearFramework\App\Data\ItemRequestEvent($sourceKey));
        }
        if ($this->hasEventListeners('itemChange')) {
            $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEvent($destinationKey));
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
     * @return self Returns a reference to itself.
     */
    public function rename(string $sourceKey, string $destinationKey): self
    {
        $driver = $this->getDriver();
        $driver->rename($sourceKey, $destinationKey);
        if ($this->hasEventListeners('itemRename')) {
            $this->dispatchEvent('itemRename', new \BearFramework\App\Data\ItemRenameEvent($sourceKey, $destinationKey));
        }
        if ($this->hasEventListeners('itemChange')) {
            $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEvent($sourceKey));
            $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEvent($destinationKey));
        }
        return $this;
    }

    /**
     * Deletes the data item specified and it's metadata.
     * 
     * @param string $key The key of the data item to delete.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @return self Returns a reference to itself.
     */
    public function delete(string $key): self
    {
        $driver = $this->getDriver();
        $driver->delete($key);
        if ($this->hasEventListeners('itemDelete')) {
            $this->dispatchEvent('itemDelete', new \BearFramework\App\Data\ItemDeleteEvent($key));
        }
        if ($this->hasEventListeners('itemChange')) {
            $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEvent($key));
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
     * @return self Returns a reference to itself.
     */
    public function setMetadata(string $key, string $name, string $value): self
    {
        $driver = $this->getDriver();
        $driver->setMetadata($key, $name, $value);
        if ($this->hasEventListeners('itemSetMetadata')) {
            $this->dispatchEvent('itemSetMetadata', new \BearFramework\App\Data\ItemSetMetadataEvent($key, $name, $value));
        }
        if ($this->hasEventListeners('itemChange')) {
            $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEvent($key));
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
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function getMetadata(string $key, string $name): ?string
    {
        $driver = $this->getDriver();
        $value = $driver->getMetadata($key, $name);
        if ($this->hasEventListeners('itemGetMetadata')) {
            $this->dispatchEvent('itemGetMetadata', new \BearFramework\App\Data\ItemGetMetadataEvent($key, $name, $value));
        }
        if ($this->hasEventListeners('itemRequest')) {
            $this->dispatchEvent('itemRequest', new \BearFramework\App\Data\ItemRequestEvent($key));
        }
        return $value;
    }

    /**
     * Deletes metadata for the data item key specified.
     * 
     * @param string $key The data item key.
     * @param string $name The metadata name.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @return self Returns a reference to itself.
     */
    public function deleteMetadata(string $key, string $name): self
    {
        $driver = $this->getDriver();
        $driver->deleteMetadata($key, $name);
        if ($this->hasEventListeners('itemDeleteMetadata')) {
            $this->dispatchEvent('itemDeleteMetadata', new \BearFramework\App\Data\ItemDeleteMetadataEvent($key, $name));
        }
        if ($this->hasEventListeners('itemChange')) {
            $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEvent($key));
        }
        return $this;
    }

    /**
     * Returns a list of all items in the data storage.
     * 
     * @return \BearFramework\DataList|\BearFramework\App\DataItem[] A list of all items in the data storage.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function getList(): \BearFramework\DataList
    {
        $list = new \BearFramework\DataList(function(\BearFramework\DataList\Context $context) {
            $driver = $this->getDriver();
            return $driver->getList($context);
        });
        if ($this->hasEventListeners('getList')) {
            $this->dispatchEvent('getList', new \BearFramework\App\Data\GetListEvent($list));
        }
        return $list;
    }

    /**
     * Checks if a data item key is valid.
     * 
     * @param string $key The key of the data item to check.
     * @return bool TRUE if valid. FALSE otherwise.
     */
    public function validate(string $key): bool
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
        if (!$this->validate($key)) {
            throw new \InvalidArgumentException('The key argument is not valid!');
        }
        return $this->filenameProtocol . '://' . $key;
    }

}
