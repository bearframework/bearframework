<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\Internal;

/**
 * Data item stream wrapper
 * @internal
 */
class DataItemStreamWrapper
{

    /**
     *
     * @var string 
     */
    private $key = null;

    /**
     *
     * @var ?\BearFramework\App\IDataItemStreamWrapper
     */
    private $dataItemWrapper = null;

    /**
     *
     * @var ?array
     */
    private $dataItemPathInfo = null;

    /**
     *
     * @var array 
     */
    private $eventToDispatchOnClose = [];

    /**
     *
     * @var ?string 
     */
    private $writtenData = null;

    /**
     *
     * @var array 
     */
    public static $environment = [];

    /**
     *
     * @var int 
     */
    private $dirPointer = 0;

    /**
     *
     * @var array 
     */
    private $dirFiles = [];

    /**
     * 
     * @param string $path
     * @param string $mode
     * @param int $options
     * @param mixed $opened_path
     * @return bool
     * @throws \Exception
     */
    public function stream_open(string $path, string $mode, int $options, $opened_path): bool
    {
        $supportedModes = ['rb', 'r+b', 'wb', 'w+b', 'ab', 'a+b', 'xb', 'x+b', 'cb', 'c+b'];
        if (array_search($mode, $supportedModes) === false) {
            throw new \Exception('The mode provided (' . $mode . ') is not supported!');
        }
        $pathInfo = $this->getPathInfo($path);
        if ($pathInfo === false) {
            return false;
        }
        $this->key = $pathInfo['key'];
        $dataDriver = $pathInfo['dataDriver'];
        $this->dataItemWrapper = $dataDriver->getDataItemStreamWrapper($this->key);
        if (array_search($mode, ['r', 'rb']) !== false && !$this->dataItemWrapper->exists()) {
            return false;
        }
        $this->dataItemPathInfo = $pathInfo;
        $dataRepository = $pathInfo['dataRepository'];
        if (array_search($mode, ['wb', 'w+b', 'xb', 'x+b', 'c', 'c+b']) !== false && $dataRepository->hasEventListeners('itemSetValue')) {
            if ($mode === 'wb') {
                $mode = 'w+b';
            } elseif ($mode === 'xb') {
                $mode = 'x+b';
            } elseif ($mode === 'cb') {
                $mode = 'c+b';
            }
            $this->eventToDispatchOnClose['itemSetValue'] = 1;
        }
        if (array_search($mode, ['ab', 'a+b']) !== false && $dataRepository->hasEventListeners('itemAppend')) {
            if ($mode === 'ab') {
                $mode = 'a+b';
            }
            $this->eventToDispatchOnClose['itemAppend'] = 1;
            $this->writtenData = '';
        }
        if (array_search($mode, ['rb', 'r+b']) !== false && $dataRepository->hasEventListeners('itemGetValue')) {
            $this->eventToDispatchOnClose['itemGetValue'] = 1;
        }
        return $this->dataItemWrapper->open($mode);
    }

    /**
     * 
     * @return void
     */
    public function stream_close(): void
    {
        $hasItemSetValueListeners = isset($this->eventToDispatchOnClose['itemSetValue']);
        $hasItemAppendListeners = isset($this->eventToDispatchOnClose['itemAppend']);
        $hasItemGetValueListeners = isset($this->eventToDispatchOnClose['itemGetValue']);
        if ($hasItemSetValueListeners || $hasItemAppendListeners || $hasItemGetValueListeners) {
            $dataRepository = $this->dataItemPathInfo['dataRepository'];
            if ($hasItemSetValueListeners || $hasItemGetValueListeners) {
                $this->dataItemWrapper->seek(0, SEEK_SET);
                $value = '';
                while (!$this->dataItemWrapper->eof()) {
                    $value .= $this->dataItemWrapper->read(8192);
                }
            }
        }
        $this->dataItemWrapper->close();
        if ($hasItemSetValueListeners) {
            $dataRepository->dispatchEvent('itemSetValue', new \BearFramework\App\Data\ItemSetValueEventDetails($this->key, $value));
        }
        if ($hasItemAppendListeners) {
            $dataRepository->dispatchEvent('itemAppend', new \BearFramework\App\Data\ItemAppendEventDetails($this->key, $this->writtenData));
        }
        if ($hasItemGetValueListeners) {
            $dataRepository->dispatchEvent('itemGetValue', new \BearFramework\App\Data\ItemGetValueEventDetails($this->key, $value));
        }
        if (($hasItemSetValueListeners || $hasItemAppendListeners) && $dataRepository->hasEventListeners('itemChange')) {
            $dataRepository->dispatchEvent('itemChange', new \BearFramework\App\Data\ItemChangeEventDetails($this->key));
        }
        if ($hasItemGetValueListeners && $dataRepository->hasEventListeners('itemRequest')) {
            $dataRepository->dispatchEvent('itemRequest', new \BearFramework\App\Data\ItemRequestEventDetails($this->key));
        }
    }

    /**
     * 
     * @param int $count
     * @return string
     */
    public function stream_read(int $count): string
    {
        return $this->dataItemWrapper->read($count);
    }

    /**
     * 
     * @param string $data
     * @return int
     */
    public function stream_write(string $data): int
    {
        if ($this->writtenData !== null) {
            $this->writtenData .= $data;
        }
        return $this->dataItemWrapper->write($data);
    }

    /**
     * 
     * @return int
     */
    public function stream_tell(): int
    {
        return $this->dataItemWrapper->tell();
    }

    /**
     * 
     * @param int $newSize
     * @return bool
     */
    public function stream_truncate(int $newSize): bool
    {
        return $this->dataItemWrapper->truncate($newSize);
    }

    /**
     * 
     * @return bool
     */
    public function stream_flush(): bool
    {
        return $this->dataItemWrapper->flush();
    }

    /**
     * 
     * @return bool
     */
    public function stream_eof(): bool
    {
        return $this->dataItemWrapper->eof();
    }

    /**
     * 
     * @param int $offset
     * @param int $whence
     * @return bool
     */
    public function stream_seek(int $offset, int $whence): bool
    {
        return $this->dataItemWrapper->seek($offset, $whence);
    }

    /**
     * 
     * @return bool
     */
    public function stream_lock(): bool
    {
        return false;
    }

    /**
     * 
     * @return bool
     */
    public function stream_set_option(): bool
    {
        return false;
    }

    /**
     * 
     * @param string $path
     * @param int $option
     * @param mixed $value
     * @return bool
     */
    public function stream_metadata(string $path, int $option, $value): bool
    {
        return false;
    }

    /**
     * 
     * @return array
     */
    public function stream_stat(): array
    {
        $originalPointer = $this->dataItemWrapper->tell();
        $this->dataItemWrapper->seek(0, SEEK_END);
        $lastPosition = $this->dataItemWrapper->tell();
        $this->dataItemWrapper->seek($originalPointer, SEEK_SET);
        $result = [];
        $result[0] = $result['dev'] = 0;
        $result[1] = $result['ino'] = 0;
        $result[2] = $result['mode'] = 0100666; // file
        $result[3] = $result['nlink'] = 0;
        $result[4] = $result['uid'] = 0;
        $result[5] = $result['gid'] = 0;
        $result[6] = $result['rdev'] = -1;
        $result[7] = $result['size'] = $lastPosition;
        $result[8] = $result['atime'] = 0;
        $result[9] = $result['mtime'] = 0;
        $result[10] = $result['ctime'] = 0;
        $result[11] = $result['blksize'] = -1;
        $result[12] = $result['blocks'] = -1;
        return $result;
    }

    /**
     * 
     * @param string $path
     * @param int $flags
     * @return array|false
     */
    public function url_stat(string $path, int $flags)
    {
        $makeResult = function($mode, $size) {
            $result = [];
            $result[0] = $result['dev'] = 0;
            $result[1] = $result['ino'] = 0;
            $result[2] = $result['mode'] = $mode;
            $result[3] = $result['nlink'] = 0;
            $result[4] = $result['uid'] = 0;
            $result[5] = $result['gid'] = 0;
            $result[6] = $result['rdev'] = -1;
            $result[7] = $result['size'] = $size;
            $result[8] = $result['atime'] = 0;
            $result[9] = $result['mtime'] = 0;
            $result[10] = $result['ctime'] = 0;
            $result[11] = $result['blksize'] = -1;
            $result[12] = $result['blocks'] = -1;
            return $result;
        };
        if (substr($path, -3) === '://') {
            return $makeResult(0040666, 0); // dir
        } else {
            $pathInfo = $this->getPathInfo(rtrim($path, '/'));
            if ($pathInfo === false) {
                return false;
            }
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
            $caller = isset($backtrace[1], $backtrace[1]['function']) ? (isset($backtrace[1]['class']) ? $backtrace[1]['class'] . '::' : '') . $backtrace[1]['function'] : null;

            $key = $pathInfo['key'];
            $dataDriver = $pathInfo['dataDriver'];
            if (array_search($caller, ['filetype', 'is_dir', 'file_exists', 'lstat', 'stat', 'SplFileInfo::getType', 'SplFileInfo::isDir']) !== false) {
                $listContext = new \BearFramework\DataList\Context();
                $action = new \BearFramework\DataList\FilterByAction();
                $action->property = 'key';
                $action->value = $key . '/';
                $action->operator = 'startWith';
                $listContext->actions[] = $action;
                $action = new \BearFramework\DataList\SlicePropertiesAction();
                $action->properties = ['key'];
                $listContext->actions[] = $action;
                $result = $dataDriver->getList($listContext);
                if ($result->count() > 0) { // TODO optimize
                    return $makeResult(0040666, 0); // dir
                }
                if (array_search($caller, ['is_dir', 'SplFileInfo::isDir']) !== false) {
                    return false;
                }
            }
            // maybe it's a file
            if ($dataDriver->exists($key)) {
                $dataItemWrapper = $dataDriver->getDataItemStreamWrapper($key);
                $result = $makeResult(0100666, $dataItemWrapper->size()); // file
                $exists = true;
            } else {
                $exists = false;
            }
            $dataRepository = $pathInfo['dataRepository'];
            if ($dataRepository->hasEventListeners('itemExists')) {
                $dataRepository->dispatchEvent('itemExists', new \BearFramework\App\Data\ItemExistsEventDetails($key, $exists));
            }
            if ($dataRepository->hasEventListeners('itemRequest')) {
                $dataRepository->dispatchEvent('itemRequest', new \BearFramework\App\Data\ItemRequestEventDetails($key));
            }
            if ($exists) {
                return $result;
            } else {
                return false;
            }
        }
    }

    /**
     * 
     * @param string $path
     * @return bool
     */
    public function unlink(string $path): bool
    {
        $pathInfo = $this->getPathInfo($path);
        if ($pathInfo === false) {
            return false;
        }
        $dataRepository = $pathInfo['dataRepository'];
        try {
            $dataRepository->delete($pathInfo['key']); // Events are dispached here
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 
     * @param string $fromPath
     * @param string $toPath
     * @return bool
     */
    public function rename(string $fromPath, string $toPath): bool
    {
        $fromPathInfo = $this->getPathInfo($fromPath);
        if ($fromPathInfo === false) {
            return false;
        }
        $toPathInfo = $this->getPathInfo($toPath);
        if ($toPathInfo === false) {
            return false;
        }
        $fromPathDataRepository = $fromPathInfo['dataRepository'];
        $toPathDataRepository = $toPathInfo['dataRepository'];
        if ($fromPathDataRepository !== $toPathDataRepository) {
            return false;
        }
        try {
            $fromPathDataRepository->rename($fromPathInfo['key'], $toPathInfo['key']); // Events are dispached here
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 
     * @param string $path
     * @param int $options
     * @return bool
     */
    public function dir_opendir(string $path, int $options): bool
    {
        $isRoot = false;
        if (substr($path, -3) === '://') {
            $path .= 'x';
            $isRoot = true;
        }
        $path = rtrim($path, '\/');
        $pathInfo = $this->getPathInfo($path);
        if ($pathInfo === false) {
            return false;
        }
        $temp = [];
        $temp['.'] = 0;
        $temp['..'] = 0;
        $dataRepository = $pathInfo['dataRepository'];
        $list = $dataRepository->getList(); // TODO optimize
        if (!$isRoot) {
            $key = $pathInfo['key'] . '/';
            $keyLength = strlen($key);
            $list->filterBy('key', $key, 'startWith');
        }
        $result = $list->sliceProperties(['key']);
        foreach ($result as $item) {
            if (!$isRoot) {
                $item['key'] = substr($item['key'], $keyLength);
            }
            $slashPosition = strpos($item['key'], '/');
            if ($slashPosition !== false) {
                $temp[substr($item['key'], 0, $slashPosition)] = 0;
            } else {
                $temp[$item['key']] = 0;
            }
        }
        $this->dirFiles = array_keys($temp);
        unset($temp);
        return true;
    }

    /**
     * 
     * @return string|bool
     */
    public function dir_readdir()
    {
        if (isset($this->dirFiles[$this->dirPointer])) {
            $this->dirPointer++;
            return $this->dirFiles[$this->dirPointer - 1];
        } else {
            $this->dirPointer = sizeof($this->dirFiles);
            return false;
        }
    }

    /**
     * 
     * @return bool
     */
    public function dir_rewinddir(): bool
    {
        $this->dirPointer = 0;
        return true;
    }

    /**
     * 
     * @return bool
     */
    public function dir_closedir(): bool
    {
        return true;
    }

    /**
     * 
     * @param string $path
     * @param int $mode
     * @param int $options
     * @return bool
     */
    public function mkdir(string $path, int $mode, int $options): bool
    {
        return true;
    }

    /**
     * 
     * @param string $path
     * @param int $options
     * @return bool
     */
    public function rmdir(string $path, int $options): bool
    {
        return true;
    }

    /**
     * 
     * @param string $path
     * @return array|false
     */
    private function getPathInfo(string $path)
    {
        $pathParts = explode('://', $path, 2);
        if (sizeof($pathParts) !== 2) {
            return false;
        }
        $protocol = $pathParts[0];
        if (!isset(self::$environment[$protocol])) {
            return false;
        }
        $environment = self::$environment[$protocol];
        if (!isset($environment[0]) || !($environment[0] instanceof \BearFramework\App\DataRepository)) {
            return false;
        }
        $dataRepository = $environment[0];
        $key = $pathParts[1];
        if (!$dataRepository->validate($key)) {
            return false;
        }
        if (!isset($environment[1]) || !($environment[1] instanceof \BearFramework\App\IDataDriver)) {
            return false;
        }
        $dataDriver = $environment[1];
        return [
            'key' => $key,
            'dataRepository' => $dataRepository,
            'dataDriver' => $dataDriver
        ];
    }

}
