<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\FactoryException;
use Jeremeamia\Phacture\FactoryInterface;

/**
 *
 */
abstract class BaseFactory implements FactoryInterface
{
    public function create($identifier, array $options = [])
    {
        if ($this->canCreate($identifier)) {
            return $this->doCreate($identifier, $options);
        } else {
            throw FactoryException::withContext($identifier, $options, get_class($this));
        }
    }

    public function canCreate($identifier)
    {
        return true;
    }

    /**
     * @param string $identifier
     * @param array  $options
     *
     * @return mixed
     */
    abstract protected function doCreate($identifier, array $options);
}
