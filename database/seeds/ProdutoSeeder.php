<?php

use Illuminate\Database\Seeder;
use App\Model\Produto;
use App\Model\HistoricoProduto;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Produto::class, 1)->create([
                'ds_sku' => '987654321',
                'nr_quantidade' => 2
        ])->each(function ($a) {
            factory(HistoricoProduto::class, 1)->create([
                'cd_produto' => 1,
                'nr_quantidade' => 2,
                'ds_observacao' => 'Criação de produto'
            ]);
        });
    }
}