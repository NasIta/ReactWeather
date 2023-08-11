<?php

namespace common\validators;

use yii\validators\RegularExpressionValidator;

class PGTimestampValidator extends RegularExpressionValidator
{
	/**
	 * @inheritdoc
	 */
	public $pattern = '/^(19|20)?[0-9]{2}[\/\-\.]?(0[1-9]|1[0-2])[\/\-\.]?(0[1-9]|[12][0-9]|3[01])([ \t]+(0?[0-9]|1[0-9]|2[0-3])\:[0-5][0-9](\:[0-5][0-9](\.[0-9]+)?)?)?$/';

	/**
	 * @inheritdoc
	 */
	public $message = '{attribute} должен содержать дату и, необязательно, время.';
}
