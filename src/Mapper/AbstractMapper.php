<?php

namespace App\Mapper;

abstract class AbstractMapper
{
    public static function from(array | object $data): static
    {
        $reflectionClass = new \ReflectionClass(static::class);
        $parameters = [];

        foreach ($reflectionClass->getConstructor()->getParameters() as $parameter) {
            $name = $parameter->getName();
            $parameters[] = $data[$name] ?? null;
        }

        return $reflectionClass->newInstanceArgs($parameters);
    }
}
