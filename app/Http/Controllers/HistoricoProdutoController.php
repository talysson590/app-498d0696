<?php

namespace App\Http\Controllers;

use App\Model\HistoricoProduto;
use Illuminate\Http\Request;
use App\Services\HistoricoProdutoService;

class HistoricoProdutoController extends Controller
{
    /**
     * @var HistoricoProdutoService $service
     */
    protected $service;

    /**
     * Construtor da classe.
     *
     * @return VOID
     */
    public function __construct(HistoricoProdutoService $service)
    {
        $this->service = $service;
    }

    /**
     * Busca os históricos paginado.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        return $this->service->getHistoricos($request);
    }

    /**
     * Busca um histórico do produto pelo id.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function show($id)
    {
        return $this->service->buscaHistoricoById($id);
    }
}
