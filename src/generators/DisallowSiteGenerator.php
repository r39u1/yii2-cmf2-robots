<?php


namespace r39u1\robots\generators;


class DisallowSiteGenerator extends AbstractGenerator
{
    public function getLines(): array
    {
        return [
            $this->disallow('/'),
        ];
    }
}