<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarefasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_item')->nullable();
            $table->string('nome_da_tarefa');
            $table->longText('descricao');
            $table->date('data_de_inicio');
            $table->date('data_proxima_execucao');
            $table->unsignedBigInteger('id_periodo');
            $table->unsignedBigInteger('id_criador');
            $table->timestamps();

            $table->foreign('id_item')->references('id')->on('items');
            $table->foreign('id_periodo')->references('id')->on('tarefa_periodos');
            $table->foreign('id_criador')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarefas');
    }
}
