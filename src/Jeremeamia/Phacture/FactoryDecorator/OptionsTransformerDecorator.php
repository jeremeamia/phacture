<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\ClassFactory;
use Jeremeamia\Phacture\FactoryInterface;

class OptionsTransformerDecorator extends BaseDecorator
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

    public function doCreate($identifier, array $options)
    {
        return $this->innerFactory->create($identifier, call_user_func($this->callback, $identifier, $options));
    }
}
