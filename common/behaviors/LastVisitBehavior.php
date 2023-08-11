<?php

namespace common\behaviors;

use common\models\user\User;
use Exception;
use Yii;
use yii\base\Behavior;
use yii\web\Controller;

class LastVisitBehavior extends Behavior
{
	public function events()
	{
		return [
			Controller::EVENT_BEFORE_ACTION => 'beforeAction',
		];
	}

	public function beforeAction()
	{
		if (!Yii::$app->user->isGuest) {
			try {
				User::updateAll(['last_login_at' => date('Y-m-d H:i:s')], ['id' => Yii::$app->user->id]);
			} catch (Exception $e) {
				Yii::error('Невозможно обновить поле «last_login_at» (user_id = ' . Yii::$app->user->id . '): ' . $e->getMessage(), __METHOD__);
			}
		}
	}
}
