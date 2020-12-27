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
interface IDataItemStreamWrapper
{

    /**
     * 
     * @param string $mode
     * @return bool
     */
    public function open(string $mode): bool;

    /**
     * 
     * @return void
     */
    public function close(): void;

    /**
     * 
     * @param int $count
     * @return string
     */
    public function read(int $count): string;

    /**
     * 
     * @param string $data
     * @return int
     */
    public function write(string $data): int;

    /**
     * 
     * @return int
     */
    public function tell(): int;

    /**
     * 
     * @param int $newSize
     * @return bool
     */
    public function truncate(int $newSize): bool;

    /**
     * 
     * @return bool
     */
    public function flush(): bool;

    /**
     * 
     * @return bool
     */
    public function eof(): bool;

    /**
     * 
     * @param int $offset
     * @param int $whence
     * @return bool
     */
    public function seek(int $offset, int $whence): bool;

    /**
     * 
     * @return int
     */
    public function size(): int;

    /**
     * 
     * @return bool
     */
    public function exists(): bool;
}
