<?php

namespace Jeremeamia\Phacture\Factory;

/**
 * An exception thrown when an object creation fails
 */
class FactoryException extends \RuntimeException
{
    private $name;
    private $options;

    public function setName($name)
    {
        $this->name = $name;

        if (!$this->message) {
            if (is_string($name)) {
                $this->message = "Could not instantiate an object using on the provided name \"{$name}\".";
            } else {
                $this->message = "Could not instantiate an object because the name provided was not a string.";
            }
        }

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }
}
