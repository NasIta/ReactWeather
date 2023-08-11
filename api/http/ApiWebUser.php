<?php

namespace api\http;

use common\http\WebUser;

final class ApiWebUser extends WebUser
{
    public $identityCookie = [
        'name' => 'weatherapp-identity-api',
        'httpOnly' => true
    ];
}
