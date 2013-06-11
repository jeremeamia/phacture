<?php

namespace Jeremeamia\Phacture\Resolver;

interface OptionsResolverInterface
{
    /**
     * @param array|\Traversable $options
     *
     * @return array
     */
    public function resolveOptions($options);
}
