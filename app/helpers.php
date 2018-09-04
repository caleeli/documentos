<?php

function get_namespace($object)
{
    $class = explode('\\', is_object($object) ? get_class($object) : $object);
    array_pop($class);
    return implode('\\', $class);
}

function guess_model($namespace, $baseName)
{
    $name = \Illuminate\Support\Str::studly($baseName);
    return class_exists($class = "$namespace\\$name") ? $class
        : (class_exists($class = "$namespace\\" . str_singular($name)) ? $class
        : (class_exists($class = "$namespace\\" . str_plural($name)) ? $class : null));
}
