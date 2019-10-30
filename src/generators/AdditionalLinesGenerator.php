<?php


namespace r39u1\robots\generators;


use r39u1\robots\Configurable;
use krok\configure\ConfigureInterface;

class AdditionalLinesGenerator extends AbstractGenerator
{
    protected $configuration;

    public function __construct(ConfigureInterface $configure)
    {
        $this->configuration = $configure->get(Configurable::class);
    }

    public function getLines(): array
    {
        $lines = [];
        $lines = array_merge(
            $lines,
            preg_split(
                "/\r\n|\n|\r/", $this->configuration->additionalLines, -1, PREG_SPLIT_NO_EMPTY
            )
        );
        return $lines;
    }
}