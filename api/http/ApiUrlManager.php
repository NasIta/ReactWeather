<?php

namespace api\http;

use api\routing\Router;
use common\http\UrlManager;

final class ApiUrlManager extends UrlManager
{

    public function __construct($config = [])
    {
        parent::__construct([
                'rules' => (new Router())->compile(),
                'baseUrl' => '/api'
            ] + $config);
    }
}
