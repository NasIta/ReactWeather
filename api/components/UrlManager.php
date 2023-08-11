<?php

namespace api\components;

class UrlManager extends \common\components\UrlManager
{
	public $enablePrettyUrl = true;

	public $enableStrictParsing = false;

	public $showScriptName = false;

	public $rules = [
		[
			'pattern' => '<controller>/<action>',
			'route' => '<controller>/<action>',
		],
	];
}