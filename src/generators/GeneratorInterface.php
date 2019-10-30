<?php


namespace r39u1\robots\generators;


interface GeneratorInterface
{
    const ALLOW = 'Allow';
    const DISALLOW = 'Disallow';

    public function getLines(): array;
}