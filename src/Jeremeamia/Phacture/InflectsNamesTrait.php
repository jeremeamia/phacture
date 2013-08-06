<?php

namespace Jeremeamia\Phacture;

trait InflectsNamesTrait
{
    public function toSnakeCase($word)
    {
        return ctype_lower($word) ? $word : strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $word));
    }

    public function toCamelCase($word)
    {
        return str_replace(' ', '', ucwords(strtr($word, '_-', '  ')));
    }
}
