<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\ClassFactory;
use Jeremeamia\Phacture\FactoryInterface;

class NameTransformerDecorator extends BaseDecorator
{
    /**
     * @var callable
     */
    protected $callback;

    public function __construct(FactoryInterface $innerFactory = null, $callback = null)
    {
        $this->innerFactory = $innerFactory ?: new ClassFactory;

        if (is_callable($callback)) {
            $this->callback = $callback;
        } else {
            throw new \InvalidArgumentException('The value provided was not a valid callback.');
        }
    }

    public function doCreate($name, array $options)
    {
        // Use closure syntax when possible in order to allow for pass-by-reference. This is useful when you want to
        // modify the options at the same time as the name (e.g., to preserve the original name value)
        $callback = $this->callback;
        if ($callback instanceof \Closure) {
            $name = $callback($name, $options);
        } else {
            $name = call_user_func($callback, $name, $options);
        }

        return $this->innerFactory->create($name, $options);
    }
}
