<?php

namespace Jeremeamia\Phacture\Resolver;

interface OptionsResolverInterface
{
    /**
     * @param mixed $options
     *
     * @return array
     */
    public function resolveOptions($options);
}
