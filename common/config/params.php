<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    [
        'http' => [
            'scheme' => 'https',
            'domain' => 'weatherapp.ru',
            'port' => ''
        ]
    ],
    file_exists(Yii::getAlias('@common/config/params-local.php')) ? require Yii::getAlias('@common/config/params-local.php') : []
);
