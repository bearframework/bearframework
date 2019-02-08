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
class NullDataItemStreamWrapper implements \BearFramework\App\IDataItemStreamWrapper
{

    /**
     * 
     * @param string $mode
     * @return bool
     */
    public function open(string $mode): bool
    {
        return true;
    }

    /**
     * 
     * @return void
     */
    public function close(): void
    {
        
    }

    /**
     * 
     * @param int $count
     * @return string
     */
    public function read(int $count): string
    {
        return '';
    }

    /**
     * 
     * @param string $data
     * @return int
     */
    public function write(string $data): int
    {
        return strlen($data);
    }

    /**
     * 
     * @return int
     */
    public function tell(): int
    {
        return 0;
    }

    /**
     * 
     * @param int $newSize
     * @return bool
     */
    public function truncate(int $newSize): bool
    {
        return true;
    }

    /**
     * 
     * @return bool
     */
    public function flush(): bool
    {
        return true;
    }

    /**
     * 
     * @return bool
     */
    public function eof(): bool
    {
        return true;
    }

    /**
     * 
     * @param int $offset
     * @param int $whence
     * @return bool
     */
    public function seek(int $offset, int $whence): bool
    {
        return true;
    }

    /**
     * 
     * @return int
     */
    public function size(): int
    {
        return 0;
    }

    /**
     * 
     * @return bool
     */
    public function exists(): bool
    {
        return false;
    }

}
