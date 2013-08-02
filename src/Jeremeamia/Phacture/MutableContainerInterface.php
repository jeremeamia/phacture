<?php

namespace Jeremeamia\Phacture;

/**
 * Interface for container mutable classes
 */
interface MutableContainerInterface extends ContainerInterface, \ArrayAccess
{
    /**
     * Register an item in the container with a name
     *
     * @param string $name    The name or key of the item to register
     * @param mixed  $item    The item to register in the container
     * @param array  $options Options that guide the registration of the item
     *
     * @return self
     */
    public function set($name, $item, $options = []);

    /**
     * Remove an item from the container
     *
     * @param string $name The name or key of the item to remove
     *
     * @return self
     */
    public function remove($name);
}
