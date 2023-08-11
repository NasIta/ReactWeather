<?php

namespace common\http;

use Yii;
use yii\helpers\VarDumper;
use yii\web\Request as BaseRequest;

abstract class Request extends BaseRequest
{
    public function constructHostInfo(): string
    {
        $hostInfo = Yii::$app->params['http']['scheme'] . '://' . Yii::$app->params['http']['domain'];
        if ($port = Yii::$app->params['http']['port']) {
            $hostInfo .= ':' . $port;
        }

        return $hostInfo;
    }
}
