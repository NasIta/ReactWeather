<?php

namespace common\http;

use common\models\user\User;
use yii\web\User as YiiWebUser;

abstract class WebUser extends YiiWebUser
{
    public $enableAutoLogin = true;
    public $identityClass = User::class;
}
