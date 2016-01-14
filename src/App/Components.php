<?php

namespace App;

class Components
{

    /**
     *
     * @var array 
     */
    private $aliases = [];

    /**
     * 
     * @param string $alias
     * @param string $original
     * @throws \InvalidArgumentException
     */
    function addAlias($alias, $original)
    {
        if (!is_string($alias)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_string($original)) {
            throw new \InvalidArgumentException('');
        }
        $this->aliases[] = ['alias' => $alias, 'original' => $original];
    }

    /**
     * 
     * @param string $content
     * @return string
     * @throws \InvalidArgumentException
     */
    function process($content)
    {
        if (!is_string($content)) {
            throw new \InvalidArgumentException('');
        }
        if (strpos($content, '<component') !== false) {
            $compiler = new \App\ComponentsCompiler();
            foreach ($this->aliases as $alias) {
                $compiler->addAlias($alias['alias'], $alias['original']);
            }
            return $compiler->process($content);
        } else {
            return $content;
        }
    }

    function insertHTML($target, $html, $position)
    {
        //todo better
        if ($position === 'afterBodyBegin') {
            //$result = str_replace('<body>', $html . '</body>', $target);
        } elseif ($position === 'beforeBodyEnd') {
            $result = str_replace('</body>', $html . '</body>', $target);
        } else {
            throw new \InvalidArgumentException('');
        }
        return $this->process($result);
    }

}
