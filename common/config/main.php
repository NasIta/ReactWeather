<?php

use kartik\grid\Module;
use yii\caching\FileCache;
use yii\log\FileTarget;
use yii\rbac\DbManager;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@admin' => '@admin',
        '@api' => '@api'
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
        'log' => [
            'targets' => [
                'sql' => [
                    'categories' => ['yii\db\Command*'],
                    'class' => FileTarget::class,
                    'enabled' => true,
                    'exportInterval' => 1,
                    'levels' => ['info'],
//                    'logFile' => '@runtime/logs/sql.log',
                    'logVars' => [],
                ],
                'main' => [
                    'class' => FileTarget::class,
                    'categories' => ['application'],
                    'logVars' => [],
                    'enabled' => true,
                    'logFile' => '@runtime/logs/debug.log',
                    'enableRotation' => false,
                    'prefix' => function () {
                        return '';
                    }
                ]
            ]
        ],
    ],
    'modules' => [
        'roundSwitch' => \nickdenry\grid\toggle\Module::class,
        'gridview' => Module::class
    ]
];
