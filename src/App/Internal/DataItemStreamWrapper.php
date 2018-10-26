<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Internal;

/**
 * Data item stream wrapper
 */
class DataItemStreamWrapper
{

    /**
     *
     * @var string 
     */
    private $protocol = null;

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
        if (strpos($mode, 't') !== false) {
            throw new \Exception('The \'t\' (text-mode translation) mode is not supported!');
        }
        if (strpos($mode, 'b') === false) {
            throw new \Exception('The \'b\' (binary) mode is required!');
        }
        $pathInfo = $this->getPathInfo($path);
        if ($pathInfo === false) {
            return false;
        }
        $this->protocol = $pathInfo['protocol'];
        $this->key = $pathInfo['key'];
        $dataDriver = $pathInfo['dataDriver'];
        $this->dataItemWrapper = $dataDriver->getDataItemStreamWrapper($this->key);
        if (array_search($mode, ['r', 'rb']) !== false && !$this->dataItemWrapper->exists()) {
            return false;
        }
        return $this->dataItemWrapper->open($mode);
    }

    /**
     * 
     * @return void
     */
    public function stream_close(): void
    {
        $this->dataItemWrapper->close();
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

        if (substr($path, -3) === '://') {
            $mode = 0040666; //dir
            $size = 0;
        } else {
            $treatAsDir = false;
            $lastCharacter = substr($path, -1);
            if ($lastCharacter === '/' || $lastCharacter === '\\') {
                $treatAsDir = true;
                $path = substr($path, 0, -1);
            }
            $pathInfo = $this->getPathInfo($path);
            if ($pathInfo === false) {
                return false;
            }
            $key = $pathInfo['key'];
            if ($treatAsDir) {
                $dataRepository = $pathInfo['dataRepository'];
                $result = $dataRepository->getList()
                        ->filterBy('key', $key, 'startWith')
                        ->sliceProperties(['key']);
                if ($result->length > 0) {
                    $mode = 0040666; //dir
                    $size = 0;
                } else {
                    return false;
                }
            } else {
                $dataDriver = $pathInfo['dataDriver'];
                if ($dataDriver->exists($key)) {
                    $dataItemWrapper = $dataDriver->getDataItemStreamWrapper($key);
                    $mode = 0100666; // file
                    $size = $dataItemWrapper->size();
                } else {
                    return false;
                }
            }
        }
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
        $dataDriver = $pathInfo['dataDriver'];
        try {
            $dataDriver->delete($pathInfo['key']);
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
        $fromPathDataDriver = $fromPathInfo['dataDriver'];
        $toPathDataDriver = $toPathInfo['dataDriver'];
        if ($fromPathDataDriver !== $toPathDataDriver) {
            return false;
        }
        try {
            $fromPathDataDriver->rename($fromPathInfo['key'], $toPathInfo['key']);
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
        $this->dirFiles[] = '.';
        $this->dirFiles[] = '..';
        $dataRepository = $pathInfo['dataRepository'];
        if ($isRoot) {
            $result = $dataRepository->getList()
                    ->sliceProperties(['key']);
            foreach ($result as $item) {
                $this->dirFiles[] = $item['key'];
            }
        } else {
            $key = $pathInfo['key'] . '/';
            $keyLength = strlen($key);
            $result = $dataRepository->getList()
                    ->filterBy('key', $key, 'startWith')
                    ->sliceProperties(['key']);
            foreach ($result as $item) {
                $this->dirFiles[] = substr($item['key'], $keyLength);
            }
        }
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
        if (!isset($environment[0]) || !($environment[0] instanceof \BearFramework\App)) {
            return false;
        }
        $app = $environment[0];
        if (!isset($environment[1]) || !($environment[1] instanceof \BearFramework\App\DataRepository)) {
            return false;
        }
        $dataRepository = $environment[1];
        $key = $pathParts[1];
        if (!$dataRepository->isValidKey($key)) {
            return false;
        }
        if (!isset($environment[2]) || !($environment[2] instanceof \BearFramework\App\IDataDriver)) {
            return false;
        }
        $dataDriver = $environment[2];
        return [
            'protocol' => $protocol,
            'key' => $key,
            'app' => $app,
            'dataRepository' => $dataRepository,
            'dataDriver' => $dataDriver
        ];
    }

}
