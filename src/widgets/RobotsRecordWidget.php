<?php


namespace r39u1\robots\widgets;


use yii\base\Widget;

class RobotsRecordWidget extends Widget
{
    public $model;
    public $form;

    public function run()
    {
        return $this->render('form', [
            'model' => $this->model,
            'form' => $this->form,
        ]);
    }

}