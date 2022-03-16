<?php

namespace App\Http\Controllers;

use App\Model\Produto;
use Illuminate\Http\Request;
use App\Services\ProdutoService;

class ProdutoController extends Controller
{
    /**
     * @var ProdutoService $service
     */
    protected $service;

    /**
     * Construtor da classe.
     *
     * @return VOID
     */
    public function __construct(ProdutoService $service)
    {
        $this->service = $service;
    }

    /**
     * Busca os produtos paginado.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        return $this->service->getProdutos($request);
    }

    /**
     * Salva um produto no banco.
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        return $this->service->salvaProduto($request);
    }

    /**
     * Busca um produto pelo id.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function show($id)
    {
        return $this->service->buscaProduto($id);
    }

    /**
     * Atualiza um produto no banco.
     *
     * @param integer $id
     * @param Request $request
     * @return array
     */
    public function update($id, Request $request)
    {
        return $this->service->atualizarProduto($id, $request);
    }

    /**
     * Remove um produto no banco.
     * 
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        return $this->service->excluirProduto($id);
    }
}
