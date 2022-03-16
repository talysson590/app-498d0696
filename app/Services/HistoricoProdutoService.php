<?php

namespace App\Services;

use App\Constants\Constants;
use App\Constants\Messages;
use App\Model\HistoricoProduto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Serviço para manipulação dos histórico de produtos.
 *
 * @category Services
 * @package  \App\Services
 * @author   Talysson Lima <diegotalysson@gmail.com>
 * @version  GIT $Id$
 */
class HistoricoProdutoService extends AbstractService
{
    /**
     * @var HistoricoProduto
     */
    public $historicoProduto;

    /**
     * HistoricoProdutoService constructor.
     */
    public function __construct(HistoricoProduto $historicoProduto)
    {
        $this->historicoProduto = $historicoProduto;
    }

    /**
     * Recupera uma lista dos produtos cadastrados
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getProdutos(Request $request)
    {
        $search = json_decode($request->input('search'));
        $sort = json_decode($request->input('sort'));

        $buscar = $this->historicoProduto->with(Constants::HISTORICO)
            ->when($search->nr_quantidade, function ($query) use ($search) {
                return $query->where(Constants::NR_QUANTIDADE, $search->nr_quantidade);
            })
            ->when($search->observacao, function ($query) use ($search) {
                return $query->where(Constants::DS_OBSERVACAO, $search->observacao);
            })
            ->when($search->criado, function ($query) use ($search) {
                return $query->where(Constants::TS_CRIADO, $search->criado);
            });

        return $buscar
            ->orderBy($sort->field, $sort->direction)
            ->paginate();
    }

    /**
     * Busca as informações de um produto.
     *
     * @param integer $id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function buscaProduto($id)
    {
       return $this->historicoProduto->with(Constants::PRODUTO)->find($id);
    }

    /**
     * Salva o histórico do porduto no banco de dados.
     *
     * @param Produto $produto
     * @param string $acao
     *
     * @return array
     */
    public function salvarHistorico($produto, $acao)
    {
        try {
            \DB::beginTransaction();
            $historicoProduto = new HistoricoProduto();
            $historicoProduto->cd_produto = $produto->cd_produto;
            $historicoProduto->nr_quantidade = $produto->nr_quantidade;
            $historicoProduto->ds_observacao = $acao;
            $historicoProduto->save();
            return $historicoProduto->toArray();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new Exception(Messages::MSG007 . ' : ' . $e->getMessage());
        }
    }
}
