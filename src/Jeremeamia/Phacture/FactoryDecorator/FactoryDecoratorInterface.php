<?php

namespace Jeremeamia\Phacture\FactoryDecorator;

use Jeremeamia\Phacture\Factory\AliasFactoryInterface;

/**
 * Interface for factory decorators.
 */
interface FactoryDecoratorInterface extends AliasFactoryInterface
{
    /**
     * Returns the factory that is being decorated
     *
     * @return AliasFactoryInterface
     */
    public function getInnerFactory();
}
