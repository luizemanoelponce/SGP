<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarefaConcluidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefa_concluidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tarefa');
            $table->string('comentario');
            $table->date('data_da_conclusao');
            $table->timestamps();

            $table->foreign('id_tarefa')->references('id')->on('tarefas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarefa_concluidas');
    }
}
