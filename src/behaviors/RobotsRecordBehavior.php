<?php


namespace r39u1\robots\behaviors;


use r39u1\robots\models\RobotsDisallowRecord;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class RobotsRecordBehavior extends Behavior
{
    const DISALLOW = 1;
    const NOT_SET = 0;

    private $_robotsStatus;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteRobotsDisallowRecord',
        ];
    }

    public function getRobotsStatus()
    {
        if ($this->owner->isNewRecord) {
            return self::NOT_SET;
        }

        if ($this->_robotsStatus === null) {
            if ($this->owner->robotsDisallowRecord) {
                $this->_robotsStatus =  self::DISALLOW;
            } else {
                $this->_robotsStatus =  self::NOT_SET;
            }
        }

        return $this->_robotsStatus;
    }

    public function setRobotsStatus($status)
    {
        if ($status == self::DISALLOW && $this->robotsStatus == self::NOT_SET) {
            $this->createRobotsDisallowRecord();
        } elseif ($status == self::NOT_SET && $this->robotsStatus == self::DISALLOW) {
            $this->deleteRobotsDisallowRecord();
        }
    }

    public function getRobotsDisallowRecord()
    {
        return $this->owner->hasOne(RobotsDisallowRecord::class, ['modelClass' => 'modelClass', 'recordId' => 'id']);
    }

    public function getModelClass()
    {
        return get_class($this->owner);
    }

    protected function deleteRobotsDisallowRecord()
    {
        $disallowRecord = $this->owner->robotsDisallowRecord;
        if ($disallowRecord) {
            $disallowRecord->delete();
        }
    }

    protected function createRobotsDisallowRecord()
    {
        if ($this->owner->id !== null) {
            $disallowRecord = new RobotsDisallowRecord();
            $disallowRecord->modelClass = $this->getModelClass();
            $disallowRecord->recordId = $this->owner->id;
            $disallowRecord->save();
        }
    }

    public static function getRobotsStatusList()
    {
        return [
            self::NOT_SET => 'Not set',
            self::DISALLOW => 'Disallow',
        ];
    }

    public function getRobotsStatusValue()
    {
        return ArrayHelper::getValue($this->getRobotsStatusList(), $this->owner->robotsStatus);
    }
}