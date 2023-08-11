<?php

use admin\http\AdminUrlManager;
use api\http\ApiRequest;
use api\http\ApiSession;
use api\http\ApiUrlManager;
use api\http\ApiWebUser;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\User;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return ArrayHelper::merge(
    require Yii::getAlias('@common/config/main.php'),
    [
        'id' => 'app-api',
        'name' => 'API',
        'language' => 'ru',
        'sourceLanguage' => 'ru',
        'basePath' => Yii::getAlias('@api'),
        'controllerNamespace' => 'api\controllers',
        //'controllerMap' => require __DIR__ . '/controllers.php',

        'bootstrap' => [
            'log',
        ],
        'components' => [
            'errorHandler' => [
                'errorAction' => 'site/error',
            ],
//            'jwt' => [
//                'class' => Jwt::class,
//            ],
            'log' => [
                'traceLevel' => YII_DEBUG ? 3 : 0,
                'targets' => [
                    'app' => [
                        'class' => \yii\log\FileTarget::class,
                        'enabled' => true,
                        'levels' => ['error', 'warning', 'info'],
                        'logFile' => '@runtime/logs/app.log',
                    ],
                    'error' => [
                        'class' => \yii\log\FileTarget::class,
                        'enabled' => true,
                        'except' => ['yii\web\HttpException:404'],
                        'levels' => ['error'],
                        'logFile' => '@runtime/logs/error.log',
                    ],
                    'http404' => [
                        'categories' => ['yii\web\HttpException:404'],
                        'class' => \yii\log\FileTarget::class,
                        'enabled' => true,
                        'levels' => ['error', 'warning'],
                        'logFile' => '@runtime/logs/http404.log',
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
                ],
            ],
            'request' => ApiRequest::class,
            'urlManager' => ApiUrlManager::class,
            'session' => ApiSession::class,
            'user' => ApiWebUser::class,
            'response' => [
                'format' => Response::FORMAT_JSON
            ],
//		'user' => [
//			'identityClass' => User::class,
//			'enableAutoLogin' => false,
//		],
        ],
        'params' => $params,
    ]
);