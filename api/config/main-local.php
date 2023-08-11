<?php

return [
	'components' => [
//		'jwt' => [
//			'key' => 'secret',
//		],
		'log' => [
			'targets' => [
				'app' => [
					'enabled' => true,
				],
				'error' => [
					'enabled' => true,
				],
				'http404' => [
					'enabled' => true,
				],
				'profile' => [
					'enabled' => true,
				],
				'sql' => [
					'enabled' => true,
				],
			],
		],
	],
];