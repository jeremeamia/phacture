<?php

namespace Jeremeamia\Phacture;

class Options
{
    /**
     * Converts the provided options argument into an array form
     *
     * @param mixed $options The provided options
     *
     * @return array
     * @throws \InvalidArgumentException If the provided value cannot be made into an array
     */
    public static function arrayify($options = array())
    {
        if (is_array($options)) {
            return $options;
        } elseif ($options instanceof \ArrayObject) {
            return $options->getArrayCopy();
        } elseif ($options instanceof \Traversable) {
            return iterator_to_array($options, true);
        } elseif (is_object($options)) {
            return get_object_vars($options);
        } elseif (is_string($options)) {
            return array($options => true);
        } else {
            throw new \InvalidArgumentException('The provided value could not be coerced into an associative array.');
        }
    }
}
