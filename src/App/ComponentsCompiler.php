<?php

namespace App;

class ComponentsCompiler extends \HTMLServerComponentsCompiler
{

    /**
     * 
     * @param array $attributes
     * @param string $innerHTML
     * @return \App\Component
     */
    protected function constructComponent($attributes = [], $innerHTML = '')
    {
        global $app;
        $component = new \App\Component();
        $component->attributes = $attributes;
        $component->innerHTML = $innerHTML;
        $app->hooks->execute('componentCreated', $component);
        return $component;
    }

    /**
     * 
     * @param string $file
     * @param \App\Component $component
     */
    protected function includeComponentFile($file, $component)
    {
        global $app;
        if (is_file($file)) {
            $__componentFile = $file;
            $context = new \App\Context();
            if (strpos($file, $app->config->appDir) === 0) {
                $context->dir = $app->config->appDir;
            } elseif (strpos($file, $app->config->addonsDir) === 0) {
                $context->dir = substr($file, 0, strpos($file, '/', strlen($app->config->appDir)) + 1);
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
