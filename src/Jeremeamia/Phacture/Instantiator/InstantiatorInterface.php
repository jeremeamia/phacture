<?php

namespace Jeremeamia\Phacture\Instantiator;

interface InstantiatorInterface
{
    /**
     * @param string $fqcn
     * @param array  $options
     *
     * @return mixed
     */
    public function instantiateClass($fqcn, array $options);
}
