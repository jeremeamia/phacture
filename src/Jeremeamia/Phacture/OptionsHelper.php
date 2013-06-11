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
        if ($options instanceof \Traversable) {
            $options = iterator_to_array($options, true);
        } elseif (is_object($options)) {
            $options = get_object_vars($options);
        } else {
            $options = (array) $options;
        }

        return $options;
    }
}
