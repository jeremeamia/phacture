<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\FactoryInterface;

/**
 * Interface for factory decorators.
 */
interface FactoryDecoratorInterface extends FactoryInterface
{
    /**
     * Returns the factory that is being decorated
     *
     * @return FactoryInterface
     */
    public function getInnerFactory();
}
