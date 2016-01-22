<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Components;

class Compiler extends \HTMLServerComponentsCompiler
{

    /**
     * 
     * @param array $attributes
     * @param string $innerHTML
     * @return \App\Component
     */
    protected function constructComponent($attributes = [], $innerHTML = '')
    {
        $app = &\App::$instance;
        $component = new \App\Components\Component();
        $component->attributes = $attributes;
        $component->innerHTML = $innerHTML;
        $app->hooks->execute('componentCreated', $component);
        return $component;
    }

    /**
     * 
     * @param string $file
     * @param App\Component $component
     */
    protected function includeComponentFile($file, $component)
    {
        $app = &\App::$instance;
        if (is_file($file)) {
            $__componentFile = $file;
            if (strpos($file, $app->config->appDir) === 0) {
                $context = new \App\AppContext($app->config->appDir);
            } elseif (strpos($file, $app->config->addonsDir) === 0) {
                $context = new \App\AddonContext(substr($file, 0, strpos($file, '/', strlen($app->config->appDir)) + 1));
            } else {
                throw new \Exception('Invalid component file path (' . $file . ')');
            }
            unset($file);
            include $__componentFile;
        } else {
            throw new \Exception('Invalid component file path (' . $file . ')');
        }
    }

}
