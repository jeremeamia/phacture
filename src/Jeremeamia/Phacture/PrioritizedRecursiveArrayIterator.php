<?php

namespace Jeremeamia\Phacture;

/**
 * A specialized version of SPL's RecursiveArrayIterator that is sorted and only recurses into array children
 */
class PrioritizedRecursiveArrayIterator extends \RecursiveArrayIterator
{
    /**
     * Constructs the recursive array iterator and does a reverse key sort. This will cause the values with higher
     * value keys (higher priorities) to be yielded first
     *
     * @param array $array
     */
    public function __construct(array $array)
    {
        krsort($array);

        parent::__construct($array);
    }

    /**
     * {@inheritdoc}
     *
     * Overrides the default hasChildren such that it only recurses into child arrays, not objects
     */
    public function hasChildren()
    {
        return is_array($this->current());
    }
}
