<?php

namespace Jeremeamia\Phacture\Factory;

use Jeremeamia\Phacture\HandlesOptionsTrait;

trait OptionsFactoryTrait
{
    use HandlesOptionsTrait;

    /**
     * Allows invocation of the factory to trigger object creation
     *
     * @param mixed $options Options for the object creation
     *
     * @return mixed The object that is instantiated
     */
    public function __invoke($options = [])
    {
        return $this->create($options);
    }

    abstract public function create($options = []);
}
