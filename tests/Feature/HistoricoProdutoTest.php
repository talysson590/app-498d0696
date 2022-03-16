<?php

namespace Tests\Feature;

use App\Constants\Constants;
use App\Constants\Messages;
use App\Model\HistoricoProduto;
use App\Model\Produto;
use App\Services\HistoricoProdutoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HistoricoProdutoTest extends TestCase
{
    /** @var HistoricoProduto */
    protected $produto;

    protected function setUp(): void
    {
        parent::setUp();
        factory(HistoricoProduto::class, 1)->create([
            'cd_produto' => factory(Produto::class),
            'nr_quantidade' => 10,
            'ds_observacao' => 'Criação de produto'
        ]);
    }

    /**
     * Teste da lista de históricos.
     *
     * @return void
     */
    public function testGetHistoricos()
    {
        $response = $this->get(
            'api/historico-produto'
        );

        $response->assertStatus(200);

    }

    /**
     * Teste de busca um histórico do produto pelo id.
     *
     * @return void
     */
    public function testBuscaHistoricoById()
    {
        $response = $this->get(
            'api/historico-produto/1'
        );

        $response->assertStatus(200);
    }
}
