<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App\DataItem;

/**
 * Data storage
 * @event \BearFramework\App\Data\ItemRequestEvent itemRequest An event dispatched after a data item is requested.
 * @event \BearFramework\App\Data\ItemChangeEvent itemChange An event dispatched after a data item is changed.
 * @event \BearFramework\App\Data\ItemBeforeSetEvent itemBeforeSet An event dispatched before a data item is added or updated.
 * @event \BearFramework\App\Data\ItemSetEvent itemSet An event dispatched after a data item is added or updated.
 * @event \BearFramework\App\Data\ItemBeforeSetValueEvent itemBeforeSetValue An event dispatched before the value of a data item is added or updated.
 * @event \BearFramework\App\Data\ItemSetValueEvent itemSetValue An event dispatched after the value of a data item is added or updated.
 * @event \BearFramework\App\Data\ItemBeforeGetEvent itemBeforeGet An event dispatched before a data item is requested.
 * @event \BearFramework\App\Data\ItemGetEvent itemGet An event dispatched after a data item is requested.
 * @event \BearFramework\App\Data\ItemBeforeGetValueEvent itemBeforeGetValue An event dispatched before the value of a data item is requested.
 * @event \BearFramework\App\Data\ItemGetValueEvent itemGetValue An event dispatched after the value of a data item is requested.
 * @event \BearFramework\App\Data\ItemBeforeGetValueLengthEvent itemBeforeGetValueLength An event dispatched before the value length of a data item is requested.
 * @event \BearFramework\App\Data\ItemGetValueLengthEvent itemGetValueLength An event dispatched after the value length of a data item is requested.
 * @event \BearFramework\App\Data\ItemBeforeExistsEvent itemBeforeExists An event dispatched before a data item is checked for existence.
 * @event \BearFramework\App\Data\ItemExistsEvent itemExists An event dispatched after a data item is checked for existence.
 * @event \BearFramework\App\Data\ItemBeforeAppendEvent itemBeforeAppend An event dispatched before a content is appended to a data value.
 * @event \BearFramework\App\Data\ItemAppendEvent itemAppend An event dispatched after a content is appended to a data value.
 * @event \BearFramework\App\Data\ItemBeforeDuplicateEvent itemBeforeDuplicate An event dispatched before a data item is duplicated.
 * @event \BearFramework\App\Data\ItemDuplicateEvent itemDuplicate An event dispatched after a data item is duplicated.
 * @event \BearFramework\App\Data\ItemBeforeRenameEvent itemBeforeRename An event dispatched before a data item is renamed.
 * @event \BearFramework\App\Data\ItemRenameEvent itemRename An event dispatched after a data item is renamed.
 * @event \BearFramework\App\Data\ItemBeforeDeleteEvent itemBeforeDelete An event dispatched before a data item is deleted.
 * @event \BearFramework\App\Data\ItemDeleteEvent itemDelete An event dispatched after a data item is deleted.
 * @event \BearFramework\App\Data\ItemBeforeSetMetadataEvent itemBeforeSetMetadata An event dispatched before a data item metadata is added or updated.
 * @event \BearFramework\App\Data\ItemSetMetadataEvent itemSetMetadata An event dispatched after a data item metadata is added or updated.
 * @event \BearFramework\App\Data\ItemBeforeGetMetadataEvent itemBeforeGetMetadata An event dispatched before a data item metadata is requested.
 * @event \BearFramework\App\Data\ItemGetMetadataEvent itemGetMetadata An event dispatched after a data item metadata is requested.
 * @event \BearFramework\App\Data\ItemBeforeDeleteMetadataEvent itemBeforeDeleteMetadata An event dispatched before a data item metadata is deleted.
 * @event \BearFramework\App\Data\ItemDeleteMetadataEvent itemDeleteMetadata An event dispatched after a data item metadata is deleted.
 * @event \BearFramework\App\Data\BeforeGetListEvent beforeGetList An event dispatched before a data items list is requested.
 * @event \BearFramework\App\Data\GetListEvent getList An event dispatched after a data items list is requested.
 * @event \BearFramework\App\Data\ItemBeforeGetStreamWrapperEventDetails itemBeforeGetStreamWrapper An event dispatched when a data items stream wrapper is requested.
 */
class DataRepository
{

    use \BearFramework\EventsTrait;

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
                if (stream_wrapper_register($this->filenameProtocol, "BearFramework\Internal\DataStreamWrapper", STREAM_IS_URL) === false) {
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
     * Enables a memory data driver. All the data will be stored in the request memory and will be deleted when the request ends.
     * 
     * @return self Returns a reference to itself.
     */
    public function useMemoryDriver(): self
    {
        $this->setDriver(new \BearFramework\App\MemoryDataDriver());
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
            \BearFramework\Internal\DataStreamWrapper::$environment[$this->filenameProtocol] = [$this, $driver];
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
        throw new \Exception('No data driver specified! Use useFileDriver(), useMemoryDriver() or setDriver() to specify one.');
    }

    /**
     * Constructs a new data item and returns it.
     * 
     * @param string|null $key The key of the data item.
     * @param string|null $value The value of the data item.
     * @return \BearFramework\App\DataItem Returns a new data item.
     * @throws \InvalidArgumentException
     */
    public function make(string $key = null, string $value = null): \BearFramework\App\DataItem
    {
        if ($this->newDataItemCache === null) {
            $this->newDataItemCache = new \BearFramework\App\DataItem();
        }
        $object = clone ($this->newDataItemCache);
        if ($key !== null) {
            if (!$this->validate($key)) {
                throw new \InvalidArgumentException('The key provided (' . $key . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
            }
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
     * @throws \InvalidArgumentException
     */
    public function set(\BearFramework\App\DataItem $item): self
    {
        if ($item->key === null || !$this->validate($item->key)) {
            throw new \InvalidArgumentException('The key provided (' . ($item->key === null ? 'null' : $item->key) . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        $metadataAsArray = $item->metadata->toArray();
        foreach ($metadataAsArray as $name => $value) {
            if (!$this->validateMetadataName($name)) {
                throw new \InvalidArgumentException('The metadata name provided (' . $name . ') is not valid! It may contain only the following characters: "a-z", "A-Z", "0-9", ".", "-" and "_".');
            }
        }
        $preventCompleteEvents = false;
        $set = function () use ($item, $metadataAsArray) {
            if (defined('BEARFRAMEWORK_DATA_ACCESS_CALLBACK')) {
                call_user_func(BEARFRAMEWORK_DATA_ACCESS_CALLBACK, 'set', $item->key, $item->value, $metadataAsArray);
            }
            $driver = $this->getDriver();
            $driver->set($item);
        };
        if ($this->hasEventListeners('itemBeforeSet')) {
            $eventDetails = new \BearFramework\App\Data\ItemBeforeSetEventDetails($item);
            $this->dispatchEvent('itemBeforeSet', $eventDetails, [
                'cancelable' => true,
                'defaultListener' => $set
            ]);
            $preventCompleteEvents = $eventDetails->preventCompleteEvents;
        } else {
            $set();
        }
        if (!$preventCompleteEvents) {
            if ($this->hasEventListeners('itemSet')) {
                $this->dispatchEvent('itemSet', new \BearFramework\App\Data\ItemSetEventDetails(clone ($item)));
            }
            if ($this->hasEventListeners('itemChange')) {
                $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEventDetails($item->key));
            }
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
     * @throws \InvalidArgumentException
     */
    public function setValue(string $key, string $value): self
    {
        if (!$this->validate($key)) {
            throw new \InvalidArgumentException('The key provided (' . $key . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        $preventCompleteEvents = false;
        $setValue = function () use ($key, $value) {
            if (defined('BEARFRAMEWORK_DATA_ACCESS_CALLBACK')) {
                call_user_func(BEARFRAMEWORK_DATA_ACCESS_CALLBACK, 'setValue', $key, $value);
            }
            $driver = $this->getDriver();
            $driver->setValue($key, $value);
        };
        if ($this->hasEventListeners('itemBeforeSetValue')) {
            $eventDetails = new \BearFramework\App\Data\ItemBeforeSetValueEventDetails($key, $value);
            $this->dispatchEvent('itemBeforeSetValue', $eventDetails, [
                'cancelable' => true,
                'defaultListener' => $setValue
            ]);
            $preventCompleteEvents = $eventDetails->preventCompleteEvents;
        } else {
            $setValue();
        }
        if (!$preventCompleteEvents) {
            if ($this->hasEventListeners('itemSetValue')) {
                $this->dispatchEvent('itemSetValue', new \BearFramework\App\Data\ItemSetValueEventDetails($key, $value));
            }
            if ($this->hasEventListeners('itemChange')) {
                $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEventDetails($key));
            }
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
     * @throws \InvalidArgumentException
     */
    public function get(string $key): ?\BearFramework\App\DataItem
    {
        if (!$this->validate($key)) {
            throw new \InvalidArgumentException('The key provided (' . $key . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        $item = null;
        $preventCompleteEvents = false;
        $get = function () use ($key) {
            if (defined('BEARFRAMEWORK_DATA_ACCESS_CALLBACK')) {
                call_user_func(BEARFRAMEWORK_DATA_ACCESS_CALLBACK, 'get', $key);
            }
            $driver = $this->getDriver();
            return $driver->get($key);
        };
        if ($this->hasEventListeners('itemBeforeGet')) {
            $eventDetails = new \BearFramework\App\Data\ItemBeforeGetEventDetails($key);
            $this->dispatchEvent('itemBeforeGet', $eventDetails, [
                'cancelable' => true,
                'defaultListener' => function ($eventDetails) use ($get) {
                    $eventDetails->returnValue = $get();
                }
            ]);
            $item = $eventDetails->returnValue;
            $preventCompleteEvents = $eventDetails->preventCompleteEvents;
        } else {
            $item = $get();
        }
        if (!$preventCompleteEvents) {
            if ($this->hasEventListeners('itemGet')) {
                $this->dispatchEvent('itemGet', new \BearFramework\App\Data\ItemGetEventDetails($key, $item === null ? null : clone ($item)));
            }
            if ($this->hasEventListeners('itemRequest')) {
                $this->dispatchEvent('itemRequest', new \BearFramework\App\Data\ItemRequestEventDetails($key));
            }
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
     * @throws \InvalidArgumentException
     */
    public function getValue(string $key): ?string
    {
        if (!$this->validate($key)) {
            throw new \InvalidArgumentException('The key provided (' . $key . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        $value = null;
        $preventCompleteEvents = false;
        $getValue = function () use ($key) {
            if (defined('BEARFRAMEWORK_DATA_ACCESS_CALLBACK')) {
                call_user_func(BEARFRAMEWORK_DATA_ACCESS_CALLBACK, 'getValue', $key);
            }
            $driver = $this->getDriver();
            return $driver->getValue($key);
        };
        if ($this->hasEventListeners('itemBeforeGetValue')) {
            $eventDetails = new \BearFramework\App\Data\ItemBeforeGetValueEventDetails($key);
            $this->dispatchEvent('itemBeforeGetValue', $eventDetails, [
                'cancelable' => true,
                'defaultListener' => function ($eventDetails) use ($getValue) {
                    $eventDetails->returnValue = $getValue();
                }
            ]);
            $value = $eventDetails->returnValue;
            $preventCompleteEvents = $eventDetails->preventCompleteEvents;
        } else {
            $value = $getValue();
        }
        if (!$preventCompleteEvents) {
            if ($this->hasEventListeners('itemGetValue')) {
                $this->dispatchEvent('itemGetValue', new \BearFramework\App\Data\ItemGetValueEventDetails($key, $value));
            }
            if ($this->hasEventListeners('itemRequest')) {
                $this->dispatchEvent('itemRequest', new \BearFramework\App\Data\ItemRequestEventDetails($key));
            }
        }
        return $value;
    }

    /**
     * Returns the value of a stored data item or null if not found.
     * 
     * @param string $key The key of the stored data item.
     * @return string|null The value of a stored data item or null if not found.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @throws \InvalidArgumentException
     */
    public function getValueLength(string $key): ?int
    {
        if (!$this->validate($key)) {
            throw new \InvalidArgumentException('The key provided (' . $key . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        $result = null;
        $preventCompleteEvents = false;
        $getValueLength = function () use ($key) {
            if (defined('BEARFRAMEWORK_DATA_ACCESS_CALLBACK')) {
                call_user_func(BEARFRAMEWORK_DATA_ACCESS_CALLBACK, 'getValueLength', $key);
            }
            $driver = $this->getDriver();
            return $driver->getValueLength($key);
        };
        if ($this->hasEventListeners('itemBeforeGetValueLength')) {
            $eventDetails = new \BearFramework\App\Data\ItemBeforeGetValueLengthEventDetails($key);
            $this->dispatchEvent('itemBeforeGetValueLength', $eventDetails, [
                'cancelable' => true,
                'defaultListener' => function ($eventDetails) use ($getValueLength) {
                    $eventDetails->returnValue = $getValueLength();
                }
            ]);
            $result = $eventDetails->returnValue;
            $preventCompleteEvents = $eventDetails->preventCompleteEvents;
        } else {
            $result = $getValueLength();
        }
        if (!$preventCompleteEvents) {
            if ($this->hasEventListeners('itemGetValueLength')) {
                $this->dispatchEvent('itemGetValueLength', new \BearFramework\App\Data\ItemGetValueLengthEventDetails($key, $result));
            }
            if ($this->hasEventListeners('itemRequest')) {
                $this->dispatchEvent('itemRequest', new \BearFramework\App\Data\ItemRequestEventDetails($key));
            }
        }
        return $result;
    }

    /**
     * Returns TRUE if the data item exists. FALSE otherwise.
     * 
     * @param string $key The key of the stored data item.
     * @return bool TRUE if the data item exists. FALSE otherwise.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @throws \InvalidArgumentException
     */
    public function exists(string $key): bool
    {
        if (!$this->validate($key)) {
            throw new \InvalidArgumentException('The key provided (' . $key . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        $result = null;
        $preventCompleteEvents = false;
        $exists = function () use ($key) {
            if (defined('BEARFRAMEWORK_DATA_ACCESS_CALLBACK')) {
                call_user_func(BEARFRAMEWORK_DATA_ACCESS_CALLBACK, 'exists', $key);
            }
            $driver = $this->getDriver();
            return $driver->exists($key);
        };
        if ($this->hasEventListeners('itemBeforeExists')) {
            $eventDetails = new \BearFramework\App\Data\ItemBeforeExistsEventDetails($key);
            $this->dispatchEvent('itemBeforeExists', $eventDetails, [
                'cancelable' => true,
                'defaultListener' => function ($eventDetails) use ($exists) {
                    $eventDetails->returnValue = $exists();
                }
            ]);
            $result = $eventDetails->returnValue;
            $preventCompleteEvents = $eventDetails->preventCompleteEvents;
        } else {
            $result = $exists();
        }
        if (!$preventCompleteEvents) {
            if ($this->hasEventListeners('itemExists')) {
                $this->dispatchEvent('itemExists', new \BearFramework\App\Data\ItemExistsEventDetails($key, $result));
            }
            if ($this->hasEventListeners('itemRequest')) {
                $this->dispatchEvent('itemRequest', new \BearFramework\App\Data\ItemRequestEventDetails($key));
            }
        }
        return $result;
    }

    /**
     * Appends data to the data item's value specified. If the data item does not exist, it will be created.
     * 
     * @param string $key The key of the data item.
     * @param string $content The content to append.
     * @return self Returns a reference to itself.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @throws \InvalidArgumentException
     */
    public function append(string $key, string $content): self
    {
        if (!$this->validate($key)) {
            throw new \InvalidArgumentException('The key provided (' . $key . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        $preventCompleteEvents = false;
        $append = function () use ($key, $content) {
            if (defined('BEARFRAMEWORK_DATA_ACCESS_CALLBACK')) {
                call_user_func(BEARFRAMEWORK_DATA_ACCESS_CALLBACK, 'append', $key, $content);
            }
            $driver = $this->getDriver();
            $driver->append($key, $content);
        };
        if ($this->hasEventListeners('itemBeforeAppend')) {
            $eventDetails = new \BearFramework\App\Data\ItemBeforeAppendEventDetails($key, $content);
            $this->dispatchEvent('itemBeforeAppend', $eventDetails, [
                'cancelable' => true,
                'defaultListener' => $append
            ]);
            $preventCompleteEvents = $eventDetails->preventCompleteEvents;
        } else {
            $append();
        }
        if (!$preventCompleteEvents) {
            if ($this->hasEventListeners('itemAppend')) {
                $this->dispatchEvent('itemAppend', new \BearFramework\App\Data\ItemAppendEventDetails($key, $content));
            }
            if ($this->hasEventListeners('itemChange')) {
                $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEventDetails($key));
            }
        }
        return $this;
    }

    /**
     * Creates a copy of the data item specified.
     * 
     * @param string $sourceKey The key of the source data item.
     * @param string $destinationKey The key of the destination data item.
     * @return self Returns a reference to itself.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @throws \InvalidArgumentException
     */
    public function duplicate(string $sourceKey, string $destinationKey): self
    {
        if (!$this->validate($sourceKey)) {
            throw new \InvalidArgumentException('The key provided (' . $sourceKey . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        if (!$this->validate($destinationKey)) {
            throw new \InvalidArgumentException('The key provided (' . $destinationKey . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        $preventCompleteEvents = false;
        $duplicate = function () use ($sourceKey, $destinationKey) {
            if (defined('BEARFRAMEWORK_DATA_ACCESS_CALLBACK')) {
                call_user_func(BEARFRAMEWORK_DATA_ACCESS_CALLBACK, 'duplicate', $sourceKey, $destinationKey);
            }
            $driver = $this->getDriver();
            $driver->duplicate($sourceKey, $destinationKey);
        };
        if ($this->hasEventListeners('itemBeforeDuplicate')) {
            $eventDetails = new \BearFramework\App\Data\ItemBeforeDuplicateEventDetails($sourceKey, $destinationKey);
            $this->dispatchEvent('itemBeforeDuplicate', $eventDetails, [
                'cancelable' => true,
                'defaultListener' => $duplicate
            ]);
            $preventCompleteEvents = $eventDetails->preventCompleteEvents;
        } else {
            $duplicate();
        }
        if (!$preventCompleteEvents) {
            if ($this->hasEventListeners('itemDuplicate')) {
                $this->dispatchEvent('itemDuplicate', new \BearFramework\App\Data\ItemDuplicateEventDetails($sourceKey, $destinationKey));
            }
            if ($this->hasEventListeners('itemRequest')) {
                $this->dispatchEvent('itemRequest', new \BearFramework\App\Data\ItemRequestEventDetails($sourceKey));
            }
            if ($this->hasEventListeners('itemChange')) {
                $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEventDetails($destinationKey));
            }
        }
        return $this;
    }

    /**
     * Changes the key of the data item specified.
     * 
     * @param string $sourceKey The current key of the data item.
     * @param string $destinationKey The new key of the data item.
     * @return self Returns a reference to itself.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @throws \InvalidArgumentException
     */
    public function rename(string $sourceKey, string $destinationKey): self
    {
        if (!$this->validate($sourceKey)) {
            throw new \InvalidArgumentException('The key provided (' . $sourceKey . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        if (!$this->validate($destinationKey)) {
            throw new \InvalidArgumentException('The key provided (' . $destinationKey . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        $preventCompleteEvents = false;
        $rename = function () use ($sourceKey, $destinationKey) {
            if (defined('BEARFRAMEWORK_DATA_ACCESS_CALLBACK')) {
                call_user_func(BEARFRAMEWORK_DATA_ACCESS_CALLBACK, 'rename', $sourceKey, $destinationKey);
            }
            $driver = $this->getDriver();
            $driver->rename($sourceKey, $destinationKey);
        };
        if ($this->hasEventListeners('itemBeforeRename')) {
            $eventDetails = new \BearFramework\App\Data\ItemBeforeRenameEventDetails($sourceKey, $destinationKey);
            $this->dispatchEvent('itemBeforeRename', $eventDetails, [
                'cancelable' => true,
                'defaultListener' => $rename
            ]);
            $preventCompleteEvents = $eventDetails->preventCompleteEvents;
        } else {
            $rename();
        }
        if (!$preventCompleteEvents) {
            if ($this->hasEventListeners('itemRename')) {
                $this->dispatchEvent('itemRename', new \BearFramework\App\Data\ItemRenameEventDetails($sourceKey, $destinationKey));
            }
            if ($this->hasEventListeners('itemChange')) {
                $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEventDetails($sourceKey));
                $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEventDetails($destinationKey));
            }
        }
        return $this;
    }

    /**
     * Deletes the data item specified and it's metadata.
     * 
     * @param string $key The key of the data item to delete.
     * @return self Returns a reference to itself.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @throws \InvalidArgumentException
     */
    public function delete(string $key): self
    {
        if (!$this->validate($key)) {
            throw new \InvalidArgumentException('The key provided (' . $key . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        $preventCompleteEvents = false;
        $delete = function () use ($key) {
            if (defined('BEARFRAMEWORK_DATA_ACCESS_CALLBACK')) {
                call_user_func(BEARFRAMEWORK_DATA_ACCESS_CALLBACK, 'delete', $key);
            }
            $driver = $this->getDriver();
            $driver->delete($key);
        };
        if ($this->hasEventListeners('itemBeforeDelete')) {
            $eventDetails = new \BearFramework\App\Data\ItemBeforeDeleteEventDetails($key);
            $this->dispatchEvent('itemBeforeDelete', $eventDetails, [
                'cancelable' => true,
                'defaultListener' => $delete
            ]);
            $preventCompleteEvents = $eventDetails->preventCompleteEvents;
        } else {
            $delete();
        }
        if (!$preventCompleteEvents) {
            if ($this->hasEventListeners('itemDelete')) {
                $this->dispatchEvent('itemDelete', new \BearFramework\App\Data\ItemDeleteEventDetails($key));
            }
            if ($this->hasEventListeners('itemChange')) {
                $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEventDetails($key));
            }
        }
        return $this;
    }

    /**
     * Stores metadata for the data item specified.
     * 
     * @param string $key The key of the data item.
     * @param string $name The metadata name.
     * @param string $value The metadata value.
     * @return self Returns a reference to itself.
     * @throws \Exception
     * @throws \InvalidArgumentException
     * @throws \BearFramework\App\Data\DataLockedException
     */
    public function setMetadata(string $key, string $name, string $value): self
    {
        if (!$this->validate($key)) {
            throw new \InvalidArgumentException('The key provided (' . $key . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        if (!$this->validateMetadataName($name)) {
            throw new \InvalidArgumentException('The metadata name provided (' . $name . ') is not valid! It may contain only the following characters: "a-z", "A-Z", "0-9", ".", "-" and "_".');
        }
        $preventCompleteEvents = false;
        $setMetadata = function () use ($key, $name, $value) {
            if (defined('BEARFRAMEWORK_DATA_ACCESS_CALLBACK')) {
                call_user_func(BEARFRAMEWORK_DATA_ACCESS_CALLBACK, 'setMetadata', $key, $name, $value);
            }
            $driver = $this->getDriver();
            $driver->setMetadata($key, $name, $value);
        };
        if ($this->hasEventListeners('itemBeforeSetMetadata')) {
            $eventDetails = new \BearFramework\App\Data\ItemBeforeSetMetadataEventDetails($key, $name, $value);
            $this->dispatchEvent('itemBeforeSetMetadata', $eventDetails, [
                'cancelable' => true,
                'defaultListener' => $setMetadata
            ]);
            $preventCompleteEvents = $eventDetails->preventCompleteEvents;
        } else {
            $setMetadata();
        }
        if (!$preventCompleteEvents) {
            if ($this->hasEventListeners('itemSetMetadata')) {
                $this->dispatchEvent('itemSetMetadata', new \BearFramework\App\Data\ItemSetMetadataEventDetails($key, $name, $value));
            }
            if ($this->hasEventListeners('itemChange')) {
                $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEventDetails($key));
            }
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
     * @throws \InvalidArgumentException
     */
    public function getMetadata(string $key, string $name): ?string
    {
        if (!$this->validate($key)) {
            throw new \InvalidArgumentException('The key provided (' . $key . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        if (!$this->validateMetadataName($name)) {
            throw new \InvalidArgumentException('The metadata name provided (' . $name . ') is not valid! It may contain only the following characters: "a-z", "A-Z", "0-9", ".", "-" and "_".');
        }
        $value = null;
        $preventCompleteEvents = false;
        $getMetadata = function () use ($key, $name) {
            if (defined('BEARFRAMEWORK_DATA_ACCESS_CALLBACK')) {
                call_user_func(BEARFRAMEWORK_DATA_ACCESS_CALLBACK, 'getMetadata', $key, $name);
            }
            $driver = $this->getDriver();
            return $driver->getMetadata($key, $name);
        };
        if ($this->hasEventListeners('itemBeforeGetMetadata')) {
            $eventDetails = new \BearFramework\App\Data\ItemBeforeGetMetadataEventDetails($key, $name);
            $this->dispatchEvent('itemBeforeGetMetadata', $eventDetails, [
                'cancelable' => true,
                'defaultListener' => function ($eventDetails) use ($getMetadata) {
                    $eventDetails->returnValue = $getMetadata();
                }
            ]);
            $value = $eventDetails->returnValue;
            $preventCompleteEvents = $eventDetails->preventCompleteEvents;
        } else {
            $value = $getMetadata();
        }
        if (!$preventCompleteEvents) {
            if ($this->hasEventListeners('itemGetMetadata')) {
                $this->dispatchEvent('itemGetMetadata', new \BearFramework\App\Data\ItemGetMetadataEventDetails($key, $name, $value));
            }
            if ($this->hasEventListeners('itemRequest')) {
                $this->dispatchEvent('itemRequest', new \BearFramework\App\Data\ItemRequestEventDetails($key));
            }
        }
        return $value;
    }

    /**
     * Deletes metadata for the data item key specified.
     * 
     * @param string $key The data item key.
     * @param string $name The metadata name.
     * @return self Returns a reference to itself.
     * @throws \Exception
     * @throws \BearFramework\App\Data\DataLockedException
     * @throws \InvalidArgumentException
     */
    public function deleteMetadata(string $key, string $name): self
    {
        if (!$this->validate($key)) {
            throw new \InvalidArgumentException('The key provided (' . $key . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        if (!$this->validateMetadataName($name)) {
            throw new \InvalidArgumentException('The metadata name provided (' . $name . ') is not valid! It may contain only the following characters: "a-z", "A-Z", "0-9", ".", "-" and "_".');
        }
        $preventCompleteEvents = false;
        $deleteMetadata = function () use ($key, $name) {
            if (defined('BEARFRAMEWORK_DATA_ACCESS_CALLBACK')) {
                call_user_func(BEARFRAMEWORK_DATA_ACCESS_CALLBACK, 'deleteMetadata', $key, $name);
            }
            $driver = $this->getDriver();
            $driver->deleteMetadata($key, $name);
        };
        if ($this->hasEventListeners('itemBeforeDeleteMetadata')) {
            $eventDetails = new \BearFramework\App\Data\ItemBeforeDeleteMetadataEventDetails($key, $name);
            $this->dispatchEvent('itemBeforeDeleteMetadata', $eventDetails, [
                'cancelable' => true,
                'defaultListener' => $deleteMetadata
            ]);
            $preventCompleteEvents = $eventDetails->preventCompleteEvents;
        } else {
            $deleteMetadata();
        }
        if (!$preventCompleteEvents) {
            if ($this->hasEventListeners('itemDeleteMetadata')) {
                $this->dispatchEvent('itemDeleteMetadata', new \BearFramework\App\Data\ItemDeleteMetadataEventDetails($key, $name));
            }
            if ($this->hasEventListeners('itemChange')) {
                $this->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEventDetails($key));
            }
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
        $preventCompleteEvents = false;
        $list = null;
        $getList = function () {
            return new \BearFramework\DataList(function (\BearFramework\DataList\Context $context) {
                if (defined('BEARFRAMEWORK_DATA_ACCESS_CALLBACK')) {
                    $actions = [];
                    foreach ($context->actions as $action) {
                        switch ($action->name) {
                            case 'filterBy':
                                $actions[] = [$action->name, $action->property, $action->value, $action->operator];
                                break;
                            case 'sortBy':
                                $actions[] = [$action->name, $action->property, $action->order];
                                break;
                            case 'sliceProperties':
                                $actions[] = [$action->name, $action->properties];
                                break;
                            case 'slice':
                                $actions[] = [$action->name, $action->offset, $action->limit];
                                break;
                            default:
                                $actions[] = [$action->name];
                                break;
                        }
                    }
                    call_user_func(BEARFRAMEWORK_DATA_ACCESS_CALLBACK, 'getList', $actions);
                }
                $driver = $this->getDriver();
                return $driver->getList($context);
            });
        };
        if ($this->hasEventListeners('beforeGetList')) {
            $eventDetails = new \BearFramework\App\Data\BeforeGetListEventDetails();
            $this->dispatchEvent('beforeGetList', $eventDetails, [
                'cancelable' => true,
                'defaultListener' => function ($eventDetails) use ($getList) {
                    $eventDetails->returnValue = $getList();
                }
            ]);
            $list = $eventDetails->returnValue;
            $preventCompleteEvents = $eventDetails->preventCompleteEvents;
        } else {
            $list = $getList();
        }
        if (!$preventCompleteEvents) {
            if ($this->hasEventListeners('getList')) {
                $this->dispatchEvent('getList', new \BearFramework\App\Data\GetListEventDetails($list));
            }
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
     * @return string The filename of the data item specified.
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    public function getFilename(string $key): string
    {
        if (!$this->validate($key)) {
            throw new \InvalidArgumentException('The key provided (' . $key . ') is not valid! It may contain only the following characters: "a-z", "0-9", ".", "/", "-" and "_".');
        }
        if ($this->filenameProtocol === null) {
            throw new \Exception('No filenameProtocol specified!');
        }
        return $this->filenameProtocol . '://' . $key;
    }

    /**
     * Checks if a data item metadata key is valid.
     * 
     * @param string $key The key of the metadata to check.
     * @return bool TRUE if valid. FALSE otherwise.
     */
    private function validateMetadataName(string $key): bool
    {
        return preg_match("/^[a-zA-Z0-9\.\-\_]*$/", $key) === 1;
    }
}
