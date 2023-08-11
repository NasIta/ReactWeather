<?php

namespace api\controllers\homepage;

use api\controllers\BaseAction;

/**
 *
 * @SWG\Get(
 *     path="/home-page/get-about",
 *     tags={"Home Page"},
 *     summary="",
 *     @SWG\Response(
 *         response = 200,
 *         description = "",
 *         @SWG\Schema(
 *             type="array",
 *             @SWG\Items(
 *                 type="object",
 *                 @SWG\Property(property="title", type="string"),
 *                 @SWG\Property(property="mainPhoto", type="string"),
 *                 @SWG\Property(property="paragraphOne", type="string"),
 *                 @SWG\Property(property="paragraphTwo", type="string"),
 *                 @SWG\Property(property="paragraphThree", type="string"),
 *                 @SWG\Property(property="achievements", type="array", @SWG\Items(
 *                     type="object",
 *                     @SWG\Property(property="achivIcon", type="string"),
 *                     @SWG\Property(property="achivTitle", type="string"),
 *                 )),
 *             ),
 *         ),
 *     ),
 * )
 *
 */
class GetAbout extends BaseAction
{
	public function run(): array
	{
		$faker = \Faker\Factory::create();

		return [
			'title' => $faker->sentence(3),
			'mainPhoto' => 'https://picsum.photos/500/500',
			'paragraphOne' => $faker->text(),
			'paragraphTwo' => $faker->text(),
			'paragraphThree' => $faker->text(),
			'achievements' => [
				['achivIcon' => 'https://picsum.photos/50/50', 'achivTitle' => $faker->sentence(4)],
				['achivIcon' => 'https://picsum.photos/50/50', 'achivTitle' => $faker->sentence(4)],
				['achivIcon' => 'https://picsum.photos/50/50', 'achivTitle' => $faker->sentence(4)],
				['achivIcon' => 'https://picsum.photos/50/50', 'achivTitle' => $faker->sentence(4)],
				['achivIcon' => 'https://picsum.photos/50/50', 'achivTitle' => $faker->sentence(4)],
			],
		];
	}
}