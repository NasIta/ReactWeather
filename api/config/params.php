<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    [

    ],
    file_exists(Yii::getAlias('@api/config/params-local.php')) ? require Yii::getAlias('@api/config/params-local.php') : []
);
