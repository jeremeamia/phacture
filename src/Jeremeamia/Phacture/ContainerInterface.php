<?php

namespace Jeremeamia\Phacture;

/**
 * Interface for container classes
 */
interface ContainerInterface extends \IteratorAggregate
{
    /**
     * Return an item from the container by name
     *
     * @param string $name    The name or key of the item to retrieve
     * @param array  $options Options that guide the retrieval of the item
     *
     * @return mixed The item registered in the container
     */
    public function get($name, $options = array());

    /**
     * Determine if an item exists in the container
     *
     * @param string $name The name or key of the item to look for
     *
     * @return bool Whether or not the item exists
     */
    public function has($name);
}
