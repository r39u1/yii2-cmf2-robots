<?php


namespace r39u1\robots\models;


use krok\extend\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class RobotsDisallowRecord extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['createdAt', 'updatedAt'], 'safe'],
        ];
    }


}