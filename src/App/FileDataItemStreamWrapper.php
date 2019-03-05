<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * 
 */
class FileDataItemStreamWrapper implements \BearFramework\App\IDataItemStreamWrapper
{

    /**
     *
     * @var string 
     */
    private $key = null;

    /**
     *
     * @var string 
     */
    private $dir = null;

    /**
     *
     * @var resource 
     */
    private $fileHandle = null;

    /**
     * 
     * @param string $key
     * @param string $dir
     */
    public function __construct(string $key, string $dir)
    {
        $this->key = $key;
        $this->dir = $dir;
    }

    /**
     * 
     * @param string $mode
     * @return bool
     */
    public function open(string $mode): bool
    {
        $filename = $this->getFilename();
        $dir = pathinfo($filename, PATHINFO_DIRNAME);
        if (!is_dir($dir)) {
            try {
                mkdir($dir, 0777, true);
            } catch (\Exception $e) {
                if ($e->getMessage() !== 'mkdir(): File exists') { // The directory may be just created in other process.
                    throw $e;
                }
            }
        }
        $getFileHandle = function() use ($filename, $mode) {
            $handle = fopen($filename, $mode);
            if ($handle) {
                $flockResult = flock($handle, $mode === 'rb' ? LOCK_SH : (LOCK_EX | LOCK_NB));
                if ($flockResult) {
                    return $handle;
                } else {
                    fclose($handle);
                }
            }
            return false;
        };
        $retriesCount = 40;
        for ($i = 0; $i < $retriesCount; $i++) {
            $handle = $getFileHandle();
            if ($handle !== false) {
                $this->fileHandle = $handle;
                return true;
            }
            if ($i < $retriesCount - 1) {
                usleep(500000);
            }
        }
        return false;
    }

    /**
     * 
     * @return void
     */
    public function close(): void
    {
        flock($this->fileHandle, LOCK_UN);
        fclose($this->fileHandle);
    }

    /**
     * 
     * @param int $count
     * @return string
     */
    public function read(int $count): string
    {
        return fread($this->fileHandle, $count);
    }

    /**
     * 
     * @param string $data
     * @return int
     */
    public function write(string $data): int
    {
        return fwrite($this->fileHandle, $data);
    }

    /**
     * 
     * @return int
     */
    public function tell(): int
    {
        return ftell($this->fileHandle);
    }

    /**
     * 
     * @param int $newSize
     * @return bool
     */
    public function truncate(int $newSize): bool
    {
        return ftruncate($this->fileHandle, $newSize);
    }

    /**
     * 
     * @return bool
     */
    public function flush(): bool
    {
        return fflush($this->fileHandle);
    }

    /**
     * 
     * @return bool
     */
    public function eof(): bool
    {
        return feof($this->fileHandle);
    }

    /**
     * 
     * @param int $offset
     * @param int $whence
     * @return bool
     */
    public function seek(int $offset, int $whence): bool
    {
        return fseek($this->fileHandle, $offset, $whence) === 0;
    }

    /**
     * 
     * @return int
     */
    public function size(): int
    {
        $filename = $this->getFilename();
        return is_file($filename) ? filesize($filename) : 0;
    }

    /**
     * 
     * @return bool
     */
    public function exists(): bool
    {
        return is_file($this->getFilename());
    }

    /**
     * 
     * @return string
     */
    private function getFilename(): string
    {
        return $this->dir . '/objects/' . $this->key;
    }

}
