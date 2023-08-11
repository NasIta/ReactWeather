<?php

namespace api\http;

use Yii;
use yii\web\Session;

final class ApiSession extends Session
{
    public function __construct($config = [])
    {
        $domain = Yii::$app->params['http']['domain'];
        parent::__construct([
                'name' => 'weatherapp-api',
                'cookieParams' => [
                    'lifetime' => 60 * 60 * 24 * 7, // неделя
                    'domain' => ".$domain",
                ],
            ] + $config);
    }
}
