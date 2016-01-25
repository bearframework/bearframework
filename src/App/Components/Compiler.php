<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Components;

/**
 * Proccess HTML code and transforms component tags
 */
class Compiler extends \HTMLServerComponentsCompiler
{

    /**
     * Constructs a Component object
     * @param array $attributes The attributes of the component tag
     * @param string $innerHTML The innerHTML of the component tag
     * @return \App\Component A component object
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
     * Includes the component file providing context information
     * @param string $file The file of the component
     * @param App\Component $component The component object for the tag specified
     * @return void No value is returned
     */
    protected function includeComponentFile($file, $component)
    {
        $app = &\App::$instance;
        if (is_file($file)) {
            $__componentFile = $file;
            if (strpos($file, $app->config->appDir) === 0) {
                $context = new \App\AppContext($app->config->appDir);
            } elseif (strpos($file, $app->config->addonsDir) === 0) {
                $context = new \App\AddonContext(substr($file, 0, strpos($file, '/', strlen($app->config->addonsDir)) + 1));
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
