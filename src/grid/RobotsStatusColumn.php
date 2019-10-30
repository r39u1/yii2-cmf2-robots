<?php


namespace r39u1\robots\grid;


use yii\grid\DataColumn;

class RobotsStatusColumn extends DataColumn
{
    public $attribute = 'robotsStatus';

    public function getDataCellValue($model, $key, $index)
    {
        if ($this->value === null) {
            return $model->getRobotsStatusValue();
        }

        return parent::getDataCellValue($model, $key, $index);
    }

    protected function renderFilterCellContent()
    {
        if ($this->filter === null) {
            $filterModel = $this->grid->filterModel;
            $this->filter = $filterModel->getRobotsStatusList();
        }

        return parent::renderFilterCellContent();
    }
}