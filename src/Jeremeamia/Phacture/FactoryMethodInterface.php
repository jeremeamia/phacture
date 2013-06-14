<?php

namespace Jeremeamia\Phacture;

/**
 * Interface for classes that have a factory method
 */
interface FactoryMethodInterface
{
    /**
     * @param array|\Traversable $options
     *
     * @return self
     */
    public static function factory($options = array());
}
