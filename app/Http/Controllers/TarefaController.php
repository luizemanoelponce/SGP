<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefa;

class TarefaController extends Controller
{
    public function index(){
        return Tarefa::getTarefasPendentes();
    }

    public function show($id){
        return Tarefa::getTarefa($id);
    }

    public function concluirTarefa($id){
        return Tarefa::concluirTarefa($id);
    }

    public function getTarefasPorItem($id){
        return Tarefa::getTarefasPorItem($id);
    }

    public function AdicionaTarefaItem($data){
        return Tarefa::AdicionaTarefaItem($data);
    }

    public function AdicionarTarefa($data){
        return Tarefa::AdicionarTarefa($data);
    }


}
