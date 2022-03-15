<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property string  observacao
 * @property Carbon  created_at
 *
 * Columns
 * @property integer nr_quantidade
 * @property string  ds_observacao
 * @property Carbon  ts_criado
 *
 * Relationships
 * @property Produto produto
 */
class HistoricoProduto extends Model
{
    /**
     * @see \Illuminate\Database\Eloquent\Model::CREATED_AT
     */
    const CREATED_AT = Constants::TS_CRIADO;

    protected $table = Constants::TB_HISTORICO_PRODUTO;

    protected $primaryKey = Constants::CD_HISTORICO_PRODUTO;

    /**
     * @var array
     */
    protected $fillable = [
        Constants::CD_PRODUTO,
        Constants::NR_QUANTIDADE,
        Constants::DS_OBSERVACAO
    ];

    /**
     * @var array
     */
    protected $maps = [
        Constants::ID                  => Constants::CD_HISTORICO_PRODUTO,
        Constants::QUANTIDADE_PRODUTOS => Constants::NR_QUANTIDADE,
        Constants::OBSERVACAO          => Constants::DS_OBSERVACAO,
        Constants::CREATED_AT          => Constants::TS_CRIADO
    ];

    /**
     * @var array
     */
    protected $casts = [
        Constants::CD_PRODUTO           => Constants::INTEGER,
        Constants::NR_QUANTIDADE        => Constants::INTEGER,
        Constants::DS_OBSERVACAO        => Constants::STRING,
        Constants::TS_CRIADO            => Constants::STRING,
    ];

    /**
     * Busca o tipo de solicitação.
     *
     * @return BelongsTo
     */
    public function produto()
    {
        return $this->belongsTo(
            Produto::class,
            Constants::CD_PRODUTO,
            Constants::CD_PRODUTO
        );
    }
}
