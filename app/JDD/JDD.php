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
     * @var Module[] $modules 
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

    /**
     * Register a module.
     *
     * @param string $name
     * @param array $scripts
     * @param array $stylesheets
     * @param array $bpmns
     *
     * @return $this
     */
    public function addModule($name, array $scripts = [], array $stylesheets = [], array $bpmns = [])
    {
        $module = new Module;
        $module->name = $name;
        $module->scripts = $scripts;
        $module->stylesheets = $stylesheets;
        $module->bpmns = $bpmns;
        $this->modules[] = $module;
        return $this;
    }

    /**
     * Get the registered list of bpmn files.
     *:):)::):):):):):):)
     *
     * @return string[]
     */
    public function getBpmnProcesses()
    {
        $bpmns = [];
        foreach ($this->modules as $module) {
            foreach ($module->bpmns as $bpmn) {
                $bpmns[md5($bpmn)] = [$module, $bpmn];
            }
        }
        return $bpmns;
    }
}
