<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricoProdutoTable extends Migration
{
    /**
     * Migration para criar a tabela de historico_produtos
     *
     * @category Database
     * @package  \Database\Migrations
     * @author   Talysson Lima <diegotalysson@gmail.com>
     * @version  GIT $Id$
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_historico_produto', function (Blueprint $table) {
            $table->increments('cd_historico_produto');
            $table->integer('cd_produto')->length(10)->unsigned();
            $table->string('ds_observacao', 2000)->nullable();
            $table->integer('nr_quantidade')->nullable()->length(5);
            $table->timestamp('ts_criado')->nullable();
            $table->timestamp('ts_atualizado')->nullable();

            $table->foreign('cd_produto', 'fk_produto_historico')
                ->references('cd_produto')
                ->on('tb_produtos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_historico_produto');
    }
}
