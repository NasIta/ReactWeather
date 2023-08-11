<?php

namespace api\http;

use common\http\Request;

final class ApiRequest extends Request
{
    public function __construct($config = [])
    {
        parent::__construct([
                'csrfParam' => '_csrf-api',
                'baseUrl' => '/api',
                'hostInfo' => $this->constructHostInfo(),
                'cookieValidationKey' => 'D_ucL1c}29$?04~D}R)k~"N~FiSYl,EZ-Y/s*_v(973M/ZQ%#@@gs$NiKq1ia+'
            ] + $config);
    }
}
