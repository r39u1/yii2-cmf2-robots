<?php

use krok\select2\Select2Widget;

?>
<?= $form->field($model, 'robotsStatus')->widget(Select2Widget::class, [
    'items' => $model->getRobotsStatusList(),
]) ?>
