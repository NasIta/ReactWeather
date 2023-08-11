<?php

namespace api\actions\weather;

use common\models\Setting;
use palax\core\result\Result;
use palax\yii2core\data\handler\DataHandler;
use palax\yii2core\data\handler\transform\Validated;
use palax\yii2core\validation\NotEmpty;
use palax\yii2core\validation\NotNull;
use palax\yii2core\validation\Trim;
use Yii;
use yii\helpers\VarDumper;
use yii\httpclient\Client;
use yii\swiftmailer\Mailer;
use yii\swiftmailer\Message;

#[Validated]
final class GetCurrentWeatherAction extends DataHandler
{
    public string $latitude;
    public string $longitude;

    protected function _run(): Result
    {
        $apiKey = Yii::$app->params['weatherApiKey'];
        $url = "https://api.openweathermap.org/data/2.5/weather?lat=$this->latitude&lon=$this->longitude&appid=$apiKey";

        $httpClient = new Client();
        $response = $httpClient->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->send();

        if ($response->isOk) {
            $data = $response->data;
            return Result::success($data);
        } else {
            return Result::critical('Failed to fetch weather data');
        }
    }
}