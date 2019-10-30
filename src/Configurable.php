<?php


namespace r39u1\robots;


use krok\configure\types\DropDownType;
use krok\configure\types\TextareaType;
use krok\system\components\backend\NameInterface;
use Yii;

class Configurable extends \krok\configure\Configurable
{
    const DISALLOW = 1;
    const ALLOW = 0;

    public $disallowSite = self::DISALLOW;
    public $disallowModules;
    public $additionalLines;

    public static function label(): string
    {
        return 'Индексация сайта';
    }

    public static function attributeTypes(): array
    {
        return [
            'disallowSite' => [
                'class' => DropDownType::class,
                'config' => [
                    'items' => static::getDisallowSiteList(),
                ],
            ],
            'disallowModules' => [
                'class' => DropDownType::class,
                'config' => [
                    'items' => static::getDisallowModulesList(),
                    'options' => [
                        'multiple' => 'multiple',
                        'style' => 'width: 75%',
                    ],
                ],
            ],
            'additionalLines' => [
                'class' => TextareaType::class,
            ],
        ];
    }

    public static function getDisallowSiteList(): array
    {
        return [
            static::DISALLOW => 'Да',
            static::ALLOW => 'Нет',
        ];
    }

    public static function getDisallowModulesList(): array
    {
        $robots = Yii::$container->get(RobotsInterface::class);
        $modules = $robots->getRegisteredModulesList();
        $disallowModulesList = [];

        foreach ($modules as $module) {
            $moduleInstance = Yii::$app->getModule($module);
            if ($moduleInstance instanceof NameInterface) {
                $moduleName = $moduleInstance->name;
            } else {
                $moduleName = ucfirst($module);
            }
            $disallowModulesList[$module] = $moduleName;
        }

        return $disallowModulesList;
    }

    public function rules(): array
    {
        return [
            [['disallowSite', 'disallowModules', 'additionalLines'], 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'disallowSite' => 'Запретить индексацию сайта',
            'disallowModules' => 'Запретить отдельные модули',
            'additionalLines' => 'Дополнительные строки',
        ];
    }
}