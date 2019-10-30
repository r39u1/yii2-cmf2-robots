<?php


namespace r39u1\robots;


use r39u1\robots\generators\AdditionalLinesGenerator;
use r39u1\robots\generators\DisallowGenerator;
use r39u1\robots\generators\DisallowSiteGenerator;
use r39u1\robots\generators\GeneratorInterface;
use krok\configure\ConfigureInterface;
use Yii;
use yii\di\Instance;
use yii\helpers\FileHelper;

class Robots implements RobotsInterface
{
    public $registeredModules;

    public $path;

    protected $configurable;

    public function __construct(ConfigureInterface $configure)
    {
        $this->configurable = $configure->get(Configurable::class);
    }

    public function write(): bool
    {
        $lines = [];

        foreach ($this->getGenerators() as $generator) {
            $generator = Instance::ensure($generator, GeneratorInterface::class);

            $lines = array_merge($lines, $generator->getLines());
        }

        return file_put_contents($this->getPath(), implode(PHP_EOL, $lines)) === false ? false : true;
    }

    public function read(): string
    {
        return file_get_contents($this->getPath());
    }

    protected function getPath(): string
    {
        $path = Yii::getAlias($this->path);
        FileHelper::createDirectory(dirname($path));

        return $path;
    }

    protected function getGenerators(): array
    {
        if ($this->configurable->disallowSite == Configurable::ALLOW) {
            return [
                AdditionalLinesGenerator::class,
                DisallowGenerator::class,
            ];
        }

        return [
            AdditionalLinesGenerator::class,
            DisallowSiteGenerator::class,
        ];
    }

    public function getRegisteredModulesList(): array
    {
        return array_keys($this->registeredModules);
    }

    public function getRegisteredModelsList(string $module): array
    {
        return $this->registeredModules[$module];
    }
}