<?php

use palax\yii2core\console\controllers\OpenApiController;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => \yii\console\controllers\FixtureController::class,
            'namespace' => 'common\fixtures',
        ],
        'open-api' => OpenApiController::class
    ],
    'components' => [
        'log' => [
            'targets' => [
                'actions' => [
                    'enabled' => true,
                    'categories' => ['console controllers log'],
                    'class' => \yii\log\FileTarget::class,
                    'levels' => 0,
                    'logVars' => [],
                    'logFile' => '@runtime/logs/actions.log',
                    'exportInterval' => 1,
                ],
                'error' => [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error'],
                    'logFile' => '@runtime/logs/error.log',
                ],
                'profile' => [
                    'categories' => ['profile'],
                    'class' => \yii\log\FileTarget::class,
                    'enabled' => true,
                    'exportInterval' => 1,
                    'levels' => ['profile'],
                    'logFile' => '@runtime/logs/profile.log',
                    'logVars' => [],
                    'microtime' => true,
                ],
                'sql' => [
                    'categories' => ['yii\db\Command*'],
                    'class' => \yii\log\FileTarget::class,
                    'enabled' => true,
                    'exportInterval' => 1,
                    'levels' => ['info'],
                    'logFile' => '@runtime/logs/sql.log',
                    'logVars' => [],
                ],
                'warning' => [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['warning'],
                    'logFile' => '@runtime/logs/warning.log',
                ],
            ],
        ],
    ],
    'params' => $params,
];
