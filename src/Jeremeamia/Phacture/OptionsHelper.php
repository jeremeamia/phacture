<?php

namespace Jeremeamia\Phacture;

abstract class OptionsHelper
{
    /**
     * Coerces the provided argument into an array
     *
     * @param mixed $options
     *
     * @return array
     */
    public static function arrayify($options)
    {
        if (is_array($options)) {
            return $options;
        } elseif ($options instanceof \Traversable) {
            return iterator_to_array($options, true);
        } elseif (is_object($options)) {
            return get_object_vars($options);
        } else {
            return (array) $options;
        }
    }
}
