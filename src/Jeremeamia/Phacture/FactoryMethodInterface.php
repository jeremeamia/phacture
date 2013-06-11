<?php

namespace Jeremeamia\Phacture;

interface FactoryMethodInterface
{
    /**
     * @param array|\Traversable $options
     *
     * @return self
     */
    public static function factory($options = array());
}
