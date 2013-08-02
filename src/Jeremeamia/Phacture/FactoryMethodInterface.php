<?php

namespace Jeremeamia\Phacture;

/**
 * Interface for classes that have a factory method
 */
interface FactoryMethodInterface
{
    /**
     * @param mixed $options
     *
     * @return static
     */
    public static function factory($options = []);
}
