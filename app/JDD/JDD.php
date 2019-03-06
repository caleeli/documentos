<?php

namespace App\JDD;

use Illuminate\Support\Str;

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
     * @param array $models
     *
     * @return $this
     */
    public function addModule($name, array $scripts = [], array $stylesheets = [], array $bpmns = [], array $models = [])
    {
        $module = new Module;
        $module->name = $name;
        $module->scripts = $scripts;
        $module->stylesheets = $stylesheets;
        $module->bpmns = $bpmns;
        $module->models = $models;
        $this->modules[] = $module;
        return $this;
    }

    /**
     * Get the registered list of bpmn files.
     *
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

    /**
     * Find a model class from a URL name
     *
     * @param string $name
     */
    public function findModel($name)
    {
        $base = Str::studly($name);
        foreach ($this->modules as $module) {
            foreach ($module->models as $model) {
                $array = explode('\\', $model);
                $className = array_pop($array);
                if ($className === $base || $className === str_singular($base) || $className === str_plural($base)) {
                    return $model;
                }
            }
        }
    }
}
