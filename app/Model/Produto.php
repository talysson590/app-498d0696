<?php

namespace App\Model;

use App\Constants\Constants;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

use Illuminate\Database\Eloquent\Model;

/**
 * Model da tabela produtos
 *
 * @category Model
 * @mixin Builder
 * @package  \App\Model
 * @author   Talysson Lima <diegotalysson@gmail.com>
 * @version  GIT $Id$
 *
 * Maps
 * @property integer id
 * @property integer quantidade_produtos
 * @property string  sku
 * @property string  ic_status
 * @property Carbon  deleted
 * @property Carbon  created_at
 * @property Carbon  updated_at
 *
 * Columns
 * @property string  ds_sku
 * @property string  ic_status
 * @property integer nr_quantidade
 *
 * Relationships
 * @property HistoricoProduto historico
 */
class Produto extends Model
{
    /**
     * @see \Illuminate\Database\Eloquent\Model::CREATED_AT
     */
    const CREATED_AT = Constants::TS_CRIADO;

    /**
     * @see \Illuminate\Database\Eloquent\Model::UPDATE_AT
     */
    const UPDATED_AT = Constants::TS_ATUALIZADO;

    protected $table = Constants::TB_PRODUTOS;

    protected $primaryKey = Constants::CD_PRODUTO;

    /**
     * @var array
     */
    protected $fillable = [
        Constants::DS_SKU,
        Constants::NR_QUANTIDADE,
        Constants::IC_STATUS
    ];

    /**
     * @var array
     */
    protected $maps = [
        Constants::ID => Constants::CD_PRODUTO,
        Constants::QUANTIDADE_PRODUTOS => Constants::NR_QUANTIDADE,
        Constants::DS_SKU => Constants::SKU,
        Constants::STATUS => Constants::IC_STATUS,
        Constants::DELETED => Constants::IC_REMOVIDO,
        Constants::CREATED_AT => Constants::TS_CRIADO,
        Constants::UPDATED_AT => Constants::TS_ATUALIZADO
    ];

    /**
     * @var array
     */
    protected $casts = [
        Constants::DS_SKU        => Constants::STRING,
        Constants::NR_QUANTIDADE => Constants::INTEGER,
        Constants::IC_REMOVIDO   => Constants::STRING,
        Constants::IC_STATUS     => Constants::STRING
    ];

    /**
     * Busca o tipo de solicitação.
     *
     * @return HasMany
     */
    public function historico()
    {
        return $this->hasMany(
            HistoricoProduto::class,
            Constants::CD_PRODUTO,
            Constants::CD_PRODUTO
        );
    }
}
