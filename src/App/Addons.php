<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

class Addons
{

    /**
     *
     * @var array 
     */
    private $options = [];

    /**
     * 
     * @param string $id
     * @param array $options
     * @throws \InvalidArgumentException
     */
    function add($id, $options = [])
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('');
        }
        $this->options[$id] = ['options' => $options];
        $this->load($id);
    }

    /**
     * 
     * @param string $id
     * @throws \InvalidArgumentException
     */
    private function load($id)
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('');
        }
        $app = &\App::$instance;
        $__id = $id;
        unset($id);
        if (strlen($app->config->addonsDir) === 0) {
            throw new Exception('');
        }
        $__indexFile = realpath($app->config->addonsDir . $__id . '/index.php');
        if ($__indexFile !== false) {
            $context = new \App\AddonContext($app->config->addonsDir . $__id . '/');
            include_once $__indexFile;
        }
    }

    /**
     * 
     * @param string $id
     * @return array
     * @throws \InvalidArgumentException
     */
    function getOptions($id)
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('');
        }
        if (isset($this->options[$id])) {
            return $this->options[$id]['options'];
        }
        return [];
    }

}
