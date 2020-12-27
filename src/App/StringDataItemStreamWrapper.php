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
class StringDataItemStreamWrapper implements \BearFramework\App\IDataItemStreamWrapper
{

    /**
     *
     * @var callable 
     */
    private $getValueCallback;

    /**
     *
     * @var callable 
     */
    private $setValueCallback;

    /**
     *
     * @var callable 
     */
    private $existsCallback;

    /**
     *
     * @var callable 
     */
    private $getSizeCallback;

    /**
     * 
     * @var string
     */
    private $value = null;

    /**
     *
     * @var int
     */
    private $pointer = null;

    /**
     * 
     * @var string
     */
    private $mode = null;

    /**
     * 
     * @param callable $reader
     * @param callable $writer
     */
    public function __construct(callable $getValueCallback, callable $setValueCallback, callable $existsCallback, callable $getSizeCallback)
    {
        $this->getValueCallback = $getValueCallback;
        $this->setValueCallback = $setValueCallback;
        $this->existsCallback = $existsCallback;
        $this->getSizeCallback = $getSizeCallback;
    }

    /**
     * 
     * @param string $mode
     * @return bool
     */
    public function open(string $mode): bool
    {
        $this->value = call_user_func($this->getValueCallback);
        $this->pointer = 0;
        $this->mode = $mode;
        if ($mode === 'rb') { // Open for reading only; place the file pointer at the beginning of the file.
            if ($this->value === null) {
                return false;
            }
        } elseif ($mode === 'r+b') { // Open for reading and writing; place the file pointer at the beginning of the file.
            if ($this->value === null) {
                return false;
            }
        } elseif ($mode === 'wb') { // Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it.
            $this->value = '';
        } elseif ($mode === 'w+b') { // Open for reading and writing; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it.
            $this->value = '';
        } elseif ($mode === 'ab') { // Open for writing only; place the file pointer at the end of the file. If the file does not exist, attempt to create it. In this mode, fseek() has no effect, writes are always appended.
            if ($this->value === null) {
                $this->value = '';
            }
            $this->pointer = strlen($this->value);
        } elseif ($mode === 'a+b') { // Open for reading and writing; place the file pointer at the end of the file. If the file does not exist, attempt to create it. In this mode, fseek() only affects the reading position, writes are always appended.
            if ($this->value === null) {
                $this->value = '';
            }
            $this->pointer = strlen($this->value);
        } elseif ($mode === 'xb') { // Create and open for writing only; place the file pointer at the beginning of the file. If the file already exists, the fopen() call will fail by returning false and generating an error of level E_WARNING. If the file does not exist, attempt to create it.
            if ($this->value !== null) {
                return false;
            }
            $this->value = '';
        } elseif ($mode === 'x+b') { // Create and open for reading and writing; otherwise it has the same behavior as 'x'.
            if ($this->value !== null) {
                return false;
            }
            $this->value = '';
        } elseif ($mode === 'cb') { // Open the file for writing only. If the file does not exist, it is created. If it exists, it is neither truncated (as opposed to 'w'), nor the call to this function fails (as is the case with 'x'). The file pointer is positioned on the beginning of the file.
            if ($this->value === null) {
                $this->value = '';
            }
        } elseif ($mode === 'c+b') { // Open the file for reading and writing; otherwise it has the same behavior as 'c'.
            if ($this->value === null) {
                $this->value = '';
            }
        }
        return true;
    }

    /**
     * 
     * @return void
     */
    public function close(): void
    {
        if ($this->mode !== 'rb') {
            call_user_func($this->setValueCallback, $this->value);
        }
        $this->pointer = null;
        $this->value = null;
    }

    /**
     * 
     * @param int $count
     * @return string
     */
    public function read(int $count): string
    {
        if ($this->mode === 'wb') {
            if (version_compare(phpversion(), "7.4.0", ">=")) { // PHP 7.4 change log: These functions now also raise a notice on failure, such as when trying to write to a read-only file resource. 
                trigger_error("This file is opened for writing only", E_USER_NOTICE);
            }
            return 0;
        }
        $result = substr($this->value, $this->pointer, $count);
        $this->pointer += strlen($result);
        return $result;
    }

    /**
     * 
     * @param string $data
     * @return int
     */
    public function write(string $data): int
    {
        if ($this->mode === 'rb') {
            if (version_compare(phpversion(), "7.4.0", ">=")) { // PHP 7.4 change log: These functions now also raise a notice on failure, such as when trying to write to a read-only file resource. 
                trigger_error("This file is opened for reading only", E_USER_NOTICE);
            }
            return 0;
        }
        $dataLength = strlen($data);
        if ($dataLength > 0) {
            if ($this->mode === 'a+b') {
                $this->value .= $data;
                $this->pointer += $dataLength;
            } else {
                $beforeString = substr($this->value, 0, $this->pointer);
                $afterString = substr($this->value, $this->pointer + $dataLength);
                $beforeStringLength = strlen($beforeString);
                if ($beforeStringLength < $this->pointer) {
                    $beforeString = str_pad($beforeString, $this->pointer - $beforeStringLength, hex2bin('00'), STR_PAD_RIGHT);
                }
                $this->value = $beforeString . $data . $afterString;
                $this->pointer += $dataLength;
            }
        }
        return $dataLength;
    }

    /**
     * 
     * @return int
     */
    public function tell(): int
    {
        return $this->pointer;
    }

    /**
     * 
     * @param int $newSize
     * @return bool
     */
    public function truncate(int $newSize): bool
    {
        $valueLength = strlen($this->value);
        if ($newSize < $valueLength) {
            $this->value = substr($valueLength, 0, $newSize);
        } elseif ($newSize === $valueLength) {
            // do nothing
        } else {
            $this->value = str_pad($this->value, $newSize, hex2bin('00'), STR_PAD_RIGHT);
        }
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
        return $this->pointer >= strlen($this->value);
    }

    /**
     * 
     * @param int $offset
     * @param int $whence
     * @return bool
     */
    public function seek(int $offset, int $whence): bool
    {
        if ($this->mode === 'ab') {
            return true;
        }
        if ($whence === SEEK_SET) {
            $this->pointer = $offset;
        } elseif ($whence === SEEK_CUR) {
            $this->pointer += $offset;
        } elseif ($whence === SEEK_END) {
            $this->pointer = strlen($this->value) + $offset;
        }
        return true;
    }

    /**
     * 
     * @return int
     */
    public function size(): int
    {
        if ($this->pointer !== null) {
            return strlen($this->value);
        } else {
            return call_user_func($this->getSizeCallback);
        }
    }

    /**
     * 
     * @return bool
     */
    public function exists(): bool
    {
        if ($this->pointer !== null) {
            return $this->value !== null;
        } else {
            return call_user_func($this->existsCallback);
        }
    }
}
