<?php

namespace common\validators;

use yii\validators\RegularExpressionValidator;

class PhoneValidator extends RegularExpressionValidator
{
	/**
	 * @inheritdoc
	 */
	public $pattern = '/^\+?[\s\d]+(\([\s\d\-]+\))?[\s\d\-]+$/';

	/**
	 * @inheritdoc
	 */
	public $message = '{attribute} должен содержать телефонный номер в установленном формате.';
}
