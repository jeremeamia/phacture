<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\FactoryException;
use Jeremeamia\Phacture\FactoryInterface;

/**
 *
 */
abstract class BaseFactory implements FactoryInterface
{
    public function create($name, array $options = [])
    {
        if ($this->canCreate($name)) {
            return $this->doCreate($name, $options);
        } else {
            throw FactoryException::withContext($name, $options, get_class($this));
        }
    }

    public function canCreate($name)
    {
        return true;
    }

    /**
     * @param string $name
     * @param array  $options
     *
     * @return mixed
     */
    abstract protected function doCreate($name, array $options);
}
