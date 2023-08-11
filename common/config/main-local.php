<?php

use yii\db\Connection;

return [
    'components' => [
        'db' => [  // postgres
            'class' => Connection::class,
            'dsn' => 'pgsql:host=weatherapp.db;dbname=weatherapp',
            'username' => 'weatherapp',
            'password' => 'weatherapp',
            'charset' => 'utf8',
            'enableSchemaCache' => false,
        ],
    ],
];
