<?php


namespace r39u1\robots\controllers\frontend;


use r39u1\robots\actions\RobotsAction;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actions(): array
    {
        return [
            'index' => RobotsAction::class,
        ];
    }
}