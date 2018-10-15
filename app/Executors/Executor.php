<?php
namespace App\Executors;

use ReflectionClass;

/**
 * Evalua expresiones escritas en los comentarios de las columnas
 *
 * @author David Callizaya <davidcallizaya@gmail.com>
 */
class Executor
{

    public static $instance = null;

    /**
     * Evaluate an expression provided in the first parameter;
     *
     * @return type
     */
    public function evaluate()
    {
        $this->loadCustomMethods();
        extract((array) $this);
        return eval('return ' . func_get_arg(0) . ';');
    }

    public static function execute($code)
    {
        $class = new ReflectionClass(static::class);
        $parent = new ReflectionClass(self::class);
        $runner = 'require ' . var_export($parent->getFileName(), true) . ';'
            . 'require ' . var_export($class->getFileName(), true) . ';'
            . '; $ex = new ' . $class->getName() . '; echo json_encode($ex->evaluate(' . var_export($code, true) . '));';
        $cmd = 'php -r ' . escapeshellarg($runner);
        return json_decode(exec($cmd), true);
    }

    /**
     * Publish the public methods of the class as global functions.
     *
     */
    private function loadCustomMethods()
    {
        /* @var $method \ReflectionMethod */
        if (static::$instance === null) {
            $reflection = new ReflectionClass(static::class);
            foreach ($reflection->getMethods() as $method) {
                if ($method->isPublic() && !$method->isStatic()) {
                    $name = $method->getName();
                    eval('function ' . $name . ' (...$args) {return ' . static::class . '::$instance->' . $name . '(...$args);};');
                }
            }
        }
        static::$instance = new static();
    }
}
