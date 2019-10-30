<?php


namespace r39u1\robots\generators;


abstract class AbstractGenerator implements GeneratorInterface
{
    protected function allow(string $line): string
    {
        return static::ALLOW . ': ' . $line;
    }

    protected function disallow(string $line): string
    {
        return static::DISALLOW . ': ' . $line;
    }
}