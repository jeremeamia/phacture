<?php

namespace Jeremeamia\Phacture\Factory;

trait OptionsOnlyFactoryTrait
{
    use FactoryTrait;

    public function create($name = null, $options = [])
    {
        $options = $this->combineOptions($name, $options);

        return $this->doCreate($options);
    }

    public function canCreate($name = null, $options = [])
    {
        $options = $this->combineOptions($name, $options);

        return $this->decideIfCanCreate($options);
    }

    protected function combineOptions($name, $options)
    {
        return $this->convertOptionsToArray($options) + $this->convertOptionsToArray($name ?: []);
    }

    abstract protected function doCreate(array $options);

    abstract protected function decideIfCanCreate(array $options);
}
