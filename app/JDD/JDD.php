<?php

namespace App\JDD;

/**
 * JDD
 *
 * @author David Callizaya <davidcallizaya@gmail.com>
 */
class JDD
{

    /**
     * @var array $modules 
     */
    private $modules = [];

    /**
     * Get active modules.
     *
     * @return \App\JDD\Module[]
     */
    public function getModules()
    {
        return $this->modules;
    }

    public function addModule(array $scripts = [], array $stylesheets = [])
    {
        $module = new Module;
        $module->scripts = $scripts;
        $module->stylesheets = $stylesheets;
        $this->modules[] = $module;
    }
}
