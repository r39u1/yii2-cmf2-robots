Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist r39u1/yii2-cmf2-robots "*"
```

or add

```
"r39u1/yii2-cmf2-robots": "*"
```

to the require section of your `composer.json` file.

Configure
---------

common:

```
'container' => [
        'singletons' => [
            \krok\configure\ConfigureInterface::class => function () {
                $configurable = [
                    \app\modules\robots\Configurable::class,
                ];
            },
            \app\modules\robots\RobotsInterface::class => [
                'class' => \app\modules\robots\Robots::class,
                'path' => '@runtime/robots/robots.txt',
                'registeredModules' => [
                    // Example config for Content module:
                    'content' => [ // Module name like in application configuration
                        \krok\content\models\Content::class => [ // Models class of records that have the ability to be Disallowed
                            'route' => 'default/index',  // Route to frontend action of records
                            'attributes' => [   
                                'alias' => 'alias', // Attributes for route: 'attribute' => 'modelsValue'
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
```

...

```
    'modules' => [
        'robots' => [
            'class' => \yii\base\Module::class,
            'controllerNamespace' => 'app\modules\robots\controllers\frontend',
        ],
    ],
```

rules

```
    [
        'pattern' => 'robots',
        'route' => 'robots',
        'suffix' => '.txt',
    ],
```

console:

```
    'migrate' => [
        'class' => \yii\console\controllers\MigrateController::class,
        'migrationTable' => '{{%migration}}',
        'interactive' => false,
        'migrationPath' => [
            '@vendor/r39u1/yii2-cmf2-robots/migrations',
        ],
    ],
```

Use:
----

Model.php

```
    public function behaviors()
    {
        return [
            'RobotsRecordBehavior' => [
                'class' => RobotsRecordBehavior::class,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['robotsStatus'], 'safe'],
        ];
    }
```

Backend:

_form.php

```
<?= RobotsRecordWidget::widget([
    'model' => $model,
    'form' => $form,
]) ?>

```

