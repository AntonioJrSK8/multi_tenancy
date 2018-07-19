<?php

use App\Accounts;
use Faker\Generator as Faker;

$factory->define(App\Accounts::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
