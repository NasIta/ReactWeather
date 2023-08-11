<?php

namespace common\http;

use yii\web\UrlManager as BaseUrlManager;

final class FrontendUrlManager extends BaseUrlManager
{
    public function __construct($config = [])
    {
        parent::__construct([
                'baseUrl' => '/'
            ] + $config);
    }
}
