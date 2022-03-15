<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Migration para criar a tabela de produtos
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
        Schema::create('tb_produtos', function (Blueprint $table) {
            $table->increments('cd_produto');
            $table->string('ds_sku', 10);
            $table->integer('nr_quantidade')->nullable()->length(5);


            $table->boolean('ic_status')->default('1');
            $table->boolean('ic_removido')->default('0');
            $table->timestamp('ts_criado')->nullable();
            $table->timestamp('ts_atualizado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_produtos');
    }
}
