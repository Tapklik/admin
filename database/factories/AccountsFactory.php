<?php

$factory->define(\App\Account::class, function (Faker\Generator $faker) {

	return [
		'name' => $faker->userName,
	];
});
