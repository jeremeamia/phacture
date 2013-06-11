<?php

namespace Jeremeamia\Phacture\Resolver;

interface NameResolverInterface
{
    /**
     * @param array|\Traversable $options
     *
     * @return string
     */
    public function resolveName($options);
}
