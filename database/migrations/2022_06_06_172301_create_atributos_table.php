<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtributosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atributos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_nome_atributo');
            $table->string('valor');
            $table->unsignedBigInteger('id_usuario_criador');
            $table->unsignedBigInteger('id_usuario_ultima_atualizacao')->nullable();
            $table->timestamps();

            $table->foreign('id_nome_atributo')->references('id')->on('nome_atributos');
            $table->foreign('id_usuario_criador')->references('id')->on('users');
            $table->foreign('id_usuario_ultima_atualizacao')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atributos');
    }
}
