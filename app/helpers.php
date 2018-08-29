<?php

function get_namespace($object)
{
    $class = explode('\\', get_class($object));
    array_pop($class);
    return implode('\\', $class);
}
