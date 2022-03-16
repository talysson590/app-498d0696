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

class ProdutoTest extends TestCase
{
    /** @var Produto */
    protected $produto;

    protected function setUp(): void
    {
        parent::setUp();
        $this->produto = factory(Produto::class, 1)->create([
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

    /**
     * Teste da lista de produtos.
     *
     * @return void
     */
    public function testGetProdutos()
    {
        $response = $this->get(
            'api/produto'
        );

        $response->assertStatus(200);

    }

    /**
     * Teste busca do produto pelo ID.
     *
     * @return void
     */
    public function testBuscaProdutoById()
    {
        $response = $this->get(
            'api/produto/1'
        );

        $response->assertStatus(200);
    }

    /**
     * Teste de salvar um produto no banco.
     *
     * @return void
     */
    public function testSalvaProduto()
    {
        $produto = [
            'ds_sku' => '9999999',
            'nr_quantidade' => 30
        ];

        $response = $this->post(
            'api/produto',
            $produto
        );
        $response->assertStatus(200);
        $response->assertJson([
            Constants::SUCCESS => true,
            Constants::MESSAGE => Messages::MSG001
        ]);
    }

    /**
     * Teste de exclui um produto do banco de dados.
     *
     * @return void
     */
    public function testExcluirProduto()
    {
        $response = $this->delete(
            'api/produto/1'
        );
        $response->assertStatus(200);
        $response->assertJson([
            Constants::SUCCESS => true,
            Constants::MESSAGE => Messages::MSG003
        ]);
    }

    /**
     * Teste de atualiza uma agência no banco de dados.
     *
     * @return void
     */
    public function testAtualizarProduto()
    {
        $produto = [
            'ds_sku' => '777777',
            'nr_quantidade' => 30,
            'ic_status' => 1
        ];

        $response = $this->put(
            'api/produto/1',
            $produto
        );
        $response->assertStatus(200);
        $response->assertJson([
            Constants::SUCCESS => true,
            Constants::MESSAGE => Messages::MSG005
        ]);
    }
}
