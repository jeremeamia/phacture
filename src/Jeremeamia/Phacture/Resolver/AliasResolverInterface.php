<?php

namespace Jeremeamia\Phacture\Resolver;

interface AliasResolverInterface
{
    /**
     * @param mixed $options
     *
     * @return string
     */
    public function resolveAlias($options);
}
