<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\HistoricoProduto;
use Faker\Generator as Faker;

$factory->define(HistoricoProduto::class, function (Faker $faker) {
    return [
        'cd_produto' => 1,
        'nr_quantidade' => 10,
        'ds_observacao' => 'Criação de produto'
    ];
});
