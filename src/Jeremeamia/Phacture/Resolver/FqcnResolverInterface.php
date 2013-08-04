<?php

namespace Jeremeamia\Phacture\Resolver;

interface FqcnResolverInterface
{
    /**
     * @param mixed $alias
     *
     * @return string
     */
    public function resolveFqcn($alias);
}
