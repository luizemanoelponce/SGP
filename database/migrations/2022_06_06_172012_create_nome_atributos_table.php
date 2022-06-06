<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomeAtributosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nome_atributos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_item');
            $table->string('nome_do_atributo');
            $table->integer('status');

            $table->unsignedBigInteger('id_usuario_criador');
            $table->unsignedBigInteger('id_usuario_ultima_atualizacao')->nullable();
            $table->timestamps();

            $table->foreign('id_usuario_criador')->references('id')->on('users');
            $table->foreign('id_usuario_ultima_atualizacao')->references('id')->on('users');
            $table->foreign('id_item')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nome_atributos');
    }
}
