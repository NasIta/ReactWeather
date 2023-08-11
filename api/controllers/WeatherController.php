<?php

namespace api\controllers;

use api\actions\weather\GetCurrentWeatherAction;
use api\actions\weather\GetIsAuthorizedAction;
use palax\core\result\Result;
use palax\yii2core\api\actions\ClosureAction;
use palax\yii2core\api\actions\DataHandlerAction;
use palax\yii2core\api\controllers\ApiController;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;

class WeatherController extends ApiController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'current-weather' => ['get'],
                ],
            ]
        ]);
    }

    public function actions(): array
    {
        return [
            'current-weather' => [
                'class' => DataHandlerAction::class,
                'dataHandlerClass' => GetCurrentWeatherAction::class,
            ],
        ];
    }
}