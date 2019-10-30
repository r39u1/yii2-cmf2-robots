<?php


namespace r39u1\robots\generators;


use r39u1\robots\Configurable;
use r39u1\robots\models\RobotsDisallowRecord;
use r39u1\robots\RobotsInterface;
use krok\configure\ConfigureInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class DisallowGenerator extends AbstractGenerator
{
    protected $configuration;
    protected $robots;

    public function __construct(ConfigureInterface $configure, RobotsInterface $robots)
    {
        $this->configuration = $configure->get(Configurable::class);
        $this->robots = $robots;
    }

    public function getLines(): array
    {
        $lines = [];

        foreach ($this->robots->getRegisteredModulesList() as $module) {
            if ($this->isDisallowModule($module)) {
                $lines[] = $this->getDisallowModule($module);
            } else {
                foreach ($this->robots->getRegisteredModelsList($module) as $model => $routeConfig) {
                    $lines = array_merge($lines, $this->getDisallowRecords($module, $model, $routeConfig));
                }
            }
        }

        return $lines;
    }

    protected function isDisallowModule(string $module): bool
    {
        $disallowModules = $this->configuration->disallowModules;
        return !empty($disallowModules) && in_array($module, $disallowModules);
    }

    protected function getDisallowModule(string $module): string
    {
        return $this->disallow(Url::to(['/' . $module]));
    }

    protected function getDisallowRecords(string $module, string $model, array $routeConfig): array
    {
        $lines = [];

        $recordsIds = RobotsDisallowRecord::find()
            ->select('recordId')
            ->where(['modelClass' => $model])
            ->asArray()
            ->all();
        $records = $model::find()->where(['in', 'id', ArrayHelper::getColumn($recordsIds, 'recordId')])->all();

        $actionRoute = '/' . $module . '/' . $routeConfig['route'];
        $modelsAttributes = [];

        foreach ($records as $record) {
            $recordParams = array_map(
                static function ($value) use ($record) {
                    return $record->$value;
                },
                $routeConfig['attributes']
            );
            $modelsAttributes[] = $recordParams;
        }

        foreach ($modelsAttributes as $modelAttributes) {
            $lines[] = $this->disallow(Url::to(array_merge([$actionRoute], $modelAttributes)));
        }

        return $lines;
    }
}