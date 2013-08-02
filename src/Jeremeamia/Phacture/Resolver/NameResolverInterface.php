<?php

namespace Jeremeamia\Phacture\Resolver;

interface NameResolverInterface
{
    /**
     * @param mixed $options
     *
     * @return string
     */
    public function resolveName($options);
}
