<?php

use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    return [
        'country_id' => mt_rand(1, 5),
        'user_id' => mt_rand(1, 5),
        'amount' => mt_rand(0, 9999),
        'type' => mt_rand(0, 1),
    ];
});
