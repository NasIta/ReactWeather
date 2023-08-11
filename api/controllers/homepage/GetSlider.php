<?php

namespace api\controllers\homepage;

use api\controllers\BaseAction;

/**
 *
 * @SWG\Get(
 *     path="/home-page/get-slider",
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
 *                 @SWG\Property(property="titleDesc", type="string"),
 *                 @SWG\Property(property="description", type="string"),
 *                 @SWG\Property(property="fontColor", type="string"),
 *                 @SWG\Property(property="buttonURL", type="string"),
 *                 @SWG\Property(property="backgroundImageURL", type="string"),
 *             ),
 *         ),
 *     ),
 * )
 *
 */
class GetSlider extends BaseAction
{
	public function run(): array
	{
		$slides = [];

		for ($i = 1; $i <= 3; ++$i) {
			$slides[] = [
				'title' => "Title {$i}",
				'titleDesc' => "Title {$i} description",
				'description' => "Description {$i}",
				'fontColor' => rand(0, 100) > 50 ? substr(md5(rand()), 0, 6) : null,
				'buttonURL' => "https://palax.info/",
				'backgroundImageURL' => "https://picsum.photos/1074/371",
			];
		}

		return $slides;
	}
}