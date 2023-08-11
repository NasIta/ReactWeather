<?php

namespace api\controllers\homepage;

use api\controllers\BaseAction;

/**
 *
 * @SWG\Get(
 *     pat-h="/home-page/get-best-price-products",
 *     tags={"Home Page"},
 *     summary="",
 *     @SWG\Response(
 *         response = 200,
 *         description = "",
 *         @SWG\Schema(
 *             type="array",
 *             @SWG\Items(
 *                 type="object",
 *                 @SWG\Property(property="id", type="string"),
 *                 @SWG\Property(property="picture", type="string"),
 *                 @SWG\Property(property="title", type="string"),
 *                 @SWG\Property(property="rating", type="number"),
 *                 @SWG\Property(property="reviews", type="integer"),
 *                 @SWG\Property(property="reviewsURL", type="string"),
 *                 @SWG\Property(property="oldPrice", type="number"),
 *                 @SWG\Property(property="price", type="number"),
 *                 @SWG\Property(property="sale", type="number"),
 *             ),
 *         ),
 *     ),
 * )
 *
 */
class GetBestPriceProducts extends BaseAction
{
	public function run(): array
	{
		$faker = \Faker\Factory::create();

		$products = [];

		for ($i = 1; $i <= 12; ++$i) {
			$products[] = [
				'id' => $faker->uuid(),
				'picture' => 'https://picsum.photos/100/100',
				'title' => $faker->sentence(3),
				'rating' => $faker->numberBetween(0, 5),
				'reviews' => $faker->randomNumber(2),
				'reviewsURL' => 'https://palax.info/',
				'oldPrice' => $faker->randomNumber(5),
				'price' => $faker->randomNumber(5),
				'sale' => $faker->randomNumber(2),
			];
		}

		return $products;
	}
}