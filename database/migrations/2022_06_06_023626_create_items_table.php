<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('status');
            $table->string('localizacao')->nullable();
            $table->date('data_de_aquisicao')->nullable();
            $table->unsignedBigInteger('id_usuario_criacao');
            $table->unsignedBigInteger('id_usuario_ultima_atualizacao')->nullable();
            $table->unsignedBigInteger('id_categoria');

            $table->foreign('id_usuario_criacao')->references('id')->on('users');
            $table->foreign('id_usuario_ultima_atualizacao')->references('id')->on('users');
            $table->foreign('id_categoria')->references('id')->on('categorias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
