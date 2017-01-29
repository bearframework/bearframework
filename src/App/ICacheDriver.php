<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

interface ICacheDriver
{

    public function set(string $key, $value, int $ttl = null): void;

    public function get(string $key);

    public function delete(string $key): void;

    public function setMultiple(array $items, int $ttl = null): void;

    public function getMultiple(array $keys): array;

    public function deleteMultiple(array $keys): void;
}
