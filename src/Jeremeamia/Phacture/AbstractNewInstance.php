<?php

namespace Jeremeamia\Phacture;

abstract class AbstractNewInstance
{
    /**
     * @return static
     */
    public static function newInstance()
    {
        $class = get_called_class();
        $args = func_get_args();
        $numArgs = count($args);

        if ($numArgs === 0) {
            return new $class;
        } elseif ($numArgs === 1) {
            return new $class($args[0]);
        } elseif ($numArgs === 2) {
            return new $class($args[0], $args[1]);
        } elseif ($numArgs === 3) {
            return new $class($args[0], $args[1], $args[2]);
        } elseif ($numArgs === 4) {
            return new $class($args[0], $args[1], $args[2], $args[3]);
        } else {
            $class = new \ReflectionClass($class);
            return $class->newInstanceArgs($args);
        }
    }
}
