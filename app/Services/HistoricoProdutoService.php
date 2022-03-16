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
    public function getHistoricos(Request $request)
    {
        $search = json_decode($request->input('search'));
        $sort = $this->orderByValueExists(json_decode($request->input('sort')), Constants::TS_CRIADO);

        $buscar = $this->historicoProduto->select(Constants::TB_HISTORICO_PRODUTO.'.*')
            ->leftJoin(
                Constants::TB_PRODUTOS,
                Constants::TB_HISTORICO_PRODUTO . '.' . Constants::CD_PRODUTO,
                Constants::TB_PRODUTOS . '.' . Constants::CD_PRODUTO
                )
            ->with(Constants::PRODUTO)
            ->when($this->propertyValueExists($search, Constants::SKU), function ($query) use ($search) {
                return $query->where(Constants::TB_PRODUTOS . '.' . Constants::DS_SKU, 'LIKE', '%' . $search->sku . '%');
            })
            ->when($this->propertyValueExists($search, Constants::QUANTIDADE), function ($query) use ($search) {
                return $query->where(Constants::NR_QUANTIDADE, $search->quantidade);
            })
            ->when($this->propertyValueExists($search, Constants::OBSERVACAO), function ($query) use ($search) {
                return $query->where(Constants::DS_OBSERVACAO, $search->observacao);
            })
            ->when($this->propertyValueExists($search, Constants::CRIADO), function ($query) use ($search) {
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
    public function buscaHistoricoById($id)
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
