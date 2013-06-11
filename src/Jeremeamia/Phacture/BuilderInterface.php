<?php

namespace Jeremeamia\Phacture;

/**
 * Generic interface for builder classes.
 */
interface BuilderInterface
{
    /**
     * Build and return an object
     *
     * @return mixed The object that was instantiated
     */
    public function build();
}
