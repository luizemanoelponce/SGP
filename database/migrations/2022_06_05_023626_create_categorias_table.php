<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('status');
            $table->unsignedBigInteger('id_usuario_criacao');
            $table->unsignedBigInteger('id_usuario_ultima_atualizacao');
            $table->string('prefixo')->nullable();

            $table->foreign('id_usuario_criacao')->references('id')->on('users');
            $table->foreign('id_usuario_ultima_atualizacao')->references('id')->on('users')->nullable();
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
        Schema::dropIfExists('categorias');
    }
}
