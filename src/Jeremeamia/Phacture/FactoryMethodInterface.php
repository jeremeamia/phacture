<?php

namespace Jeremeamia\Phacture;

/**
 * Interface for classes that have a factory method
 */
interface FactoryMethodInterface
{
    /**
     * @param array $options
     *
     * @return static
     */
    public static function factory(array $options = array());
}
