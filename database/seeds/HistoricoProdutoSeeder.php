<?php

use Illuminate\Database\Seeder;
use App\Model\Produto;
use App\Model\HistoricoProduto;

class HistoricoProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(HistoricoProduto::class, 1)->create([
            'cd_produto' => factory(Produto::class),
            'nr_quantidade' => 10,
            'ds_observacao' => 'Criação de produto'
        ]);
    }
}