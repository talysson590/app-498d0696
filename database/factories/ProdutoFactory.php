<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Produto;
use Faker\Generator as Faker;

$factory->define(Produto::class, function (Faker $faker) {
    return [
        'ds_sku' => '123456',
        'nr_quantidade' => 10
    ];
});
