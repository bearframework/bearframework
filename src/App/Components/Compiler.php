<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Components;

use BearFramework\App;

/**
 * Process HTML code and transforms component tags
 */
class Compiler extends \HTMLServerComponentsCompiler
{

    /**
     * Constructs a Component object
     * @param array $attributes The attributes of the component tag
     * @param string $innerHTML The innerHTML of the component tag
     * @return \BearFramework\App\Component A component object
     */
    protected function constructComponent($attributes = [], $innerHTML = '')
    {
        $app = &App::$instance;
        $component = new App\Components\Component();
        $component->attributes = $attributes;
        $component->innerHTML = $innerHTML;
        $app->hooks->execute('componentCreated', $component);
        return $component;
    }

    /**
     * Includes the component file providing context information
     * @param string $file The file of the component
     * @param \BearFramework\App\Component $component The component object for the tag specified
     * @throws \Exception
     * @return string
     */
    protected function getComponentFileContent($file, $component)
    {
        $app = &App::$instance;
        if (is_file($file)) {
            $__componentFile = $file;
            $context = $app->getContext($file);
            unset($file);
            ob_start();
            include $__componentFile;
            $content = ob_get_clean();
            return $content;
        } else {
            throw new \Exception('Invalid component file path (' . $file . ')');
        }
    }

}
