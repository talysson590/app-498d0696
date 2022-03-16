<?php

namespace App\Services;

use App\Constants\Constants;
use App\Constants\Messages;
use App\Model\Produto;
use App\Services\HistoricoProdutoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Serviço para manipulação dos produtos.
 *
 * @category Services
 * @package  \App\Services
 * @author   Talysson Lima <diegotalysson@gmail.com>
 * @version  GIT $Id$
 */
class ProdutoService extends AbstractService
{
    /**
     * @var Produto
     */
    public $produto;

    /**
     * @var HistoricoProdutoService
     */
    public $historicoProdutoService;

    /**
     * ProdutoService constructor.
     */
    public function __construct(Produto $produto, HistoricoProdutoService $historicoProdutoService)
    {
        $this->produto = $produto;
        $this->historicoProdutoService = $historicoProdutoService;
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
        $sort = $this->orderByValueExists(json_decode($request->input('sort')), Constants::DS_SKU);

        $buscar = $this->produto->with(Constants::HISTORICO)
            ->when($this->propertyValueExists($search, Constants::SKU), function ($query) use ($search) {
                return $query->where(Constants::DS_SKU, 'LIKE', '%' . $search->sku . '%');
            })
            ->when($this->propertyValueExists($search, Constants::QUANTIDADE), function ($query) use ($search) {
                return $query->where(Constants::NR_QUANTIDADE, $search->quantidade);
            })
            ->when($this->propertyValueExists($search, Constants::STATUS), function ($query) use ($search) {
                return $query->where(Constants::IC_STATUS, $search->status);
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
    public function buscaProdutoById($id)
    {
       return $this->produto->with(Constants::HISTORICO)->find($id);
    }

    /**
     * Salva um produto no banco de dados.
     *
     * @param Request $request
     *
     * @return array
     */
    public function salvaProduto(Request $request)
    {
        \DB::beginTransaction();
        try {
            $status = Response::HTTP_OK;

            $input = $request->all();

            $produto = new Produto($input);
            
            $return = $produto->save();

            /**
             *  Salva o histórico
             *
             *  @var HistoricoProduto
             */
            $this->historicoProdutoService->salvarHistorico($produto, Constants::CADASTRO);
            \DB::commit();

            if ($return) {
                $response = [
                    Constants::SUCCESS => true,
                    Constants::MESSAGE => Messages::MSG001,
                    Constants::DATA    => $produto->toArray()
                ];
            } else {
                $response = [
                    Constants::SUCCESS => false,
                    Constants::MESSAGE => Messages::MSG002
                ];
            }
        } catch (\Exception $e) {
            \DB::rollback();
            $status = Response::HTTP_BAD_REQUEST;
            $response = [
                Constants::SUCCESS => false,
                Constants::MESSAGE => $e->getMessage()
            ];
        }

        return response()->json($response, $status);
    }

    /**
     * Exclui um produto do banco de dados.
     *
     * @param integer $id
     *
     * @return array
     */
    public function excluirProduto($id)
    {
        \DB::beginTransaction();
        try {
            $status = Response::HTTP_OK;
            $response = [
                Constants::SUCCESS => true,
                Constants::MESSAGE => Messages::MSG003
            ];
            $produto = Produto::find($id)->update([Constants::IC_REMOVIDO => 1]);
            /**
             *  Salva o histórico
             *
             *  @var HistoricoProduto
             */
            $this->historicoProdutoService->salvarHistorico(Produto::find($id), Constants::EXCLUSAO);

            if ($produto) {
                $response = [
                    Constants::SUCCESS => true,
                    Constants::MESSAGE => Messages::MSG003
                ];
            } else {
                $response = [
                    Constants::SUCCESS => false,
                    Constants::MESSAGE => Messages::MSG004
                ];
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $status = Response::HTTP_BAD_REQUEST;
            $response = [
                Constants::SUCCESS => false,
                Constants::MESSAGE => $e->getMessage()
            ];
        }

        return response()->json($response, $status);
    }

    /**
     * Atualiza uma agência no banco de dados.
     *
     * @param integer $id
     * @param Request $request
     *
     * @return array
     */
    public function atualizarProduto($id, Request $request)
    {
        \DB::beginTransaction();
        try {
            $status = Response::HTTP_OK;
            $produto = Produto::find($id);
            $produto->ds_sku = $request->input(Constants::DS_SKU);
            $produto->ic_status = $request->input(Constants::IC_STATUS);
            $produto->nr_quantidade = $request->input(Constants::NR_QUANTIDADE);

            if ($produto->save()) {
                /**
                 *  Salva o histórico
                 *
                 *  @var HistoricoProduto
                 */
                $this->historicoProdutoService->salvarHistorico($produto, Constants::ATUALIZACAO);
                $response = [
                    Constants::SUCCESS => true,
                    Constants::MESSAGE => Messages::MSG005,
                    Constants::DATA    => $produto->toArray()
                ];
            } else {
                $response = [
                    Constants::SUCCESS => false,
                    Constants::MESSAGE => Messages::MSG006
                ];
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $status = Response::HTTP_BAD_REQUEST;
            $response = [
                Constants::SUCCESS => false,
                Constants::MESSAGE => $e->getMessage()
            ];
        }

        return response()->json($response, $status);
    }
}
