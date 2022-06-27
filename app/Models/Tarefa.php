<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\TarefaPeriodo;


class Tarefa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_item',
        'nome_da_tarefa',
        'descricao',
        'data_de_inicio',
        'data_proxima_execucao',
        'id_periodo',
        'id_criador'

    ];

    public function getTarefasPendentes(){

        $hoje = date('Y-m-d');

        $tarefas = DB::table('tarefas')
            ->join('users', 'tarefas.id_criador', '=', 'users.id')
            ->select('tarefas.*', 'users.name as criador_nome')
            ->orderBy('data_proxima_execucao')
            ->where('data_proxima_execucao', '<=', $hoje)
            ->get();

        return $tarefas;
    }

    public function getTarefa($id){

        $hoje = date('Y-m-d');

        $tarefas = DB::table('tarefas')
            ->join('users', 'tarefas.id_criador', '=', 'users.id')
            ->select('tarefas.*', 'users.name as criador_nome')
            ->orderBy('data_proxima_execucao')
            ->where('tarefas.id', $id)
            ->get();

        return $tarefas;
    }

    public function concluirTarefa($id){

        $hoje = date('Y-m-d');

        $tarefas = DB::table('tarefas')
            ->join('users', 'tarefas.id_criador', '=', 'users.id')
            ->select('tarefas.*', 'users.name as criador_nome')
            ->orderBy('data_proxima_execucao')
            ->where('tarefas.id', $id)
            ->get();

        $periodo = DB::table('tarefa_periodos')
            ->select('tarefa_periodos.*')
            ->where('id', $tarefas[0]->id_periodo)
            ->get();

        $newExecution = date('Y-m-d', strtotime($periodo[0]->periodo, strtotime($tarefas[0]->data_proxima_execucao)));
        
        Tarefa::where('id', $tarefas[0]->id)
            ->update([
                'data_proxima_execucao' => $newExecution
            ]);
    }

    public function getTarefasPorItem($id){
        $tarefas = DB::table('tarefas')
            ->join('users', 'tarefas.id_criador', '=', 'users.id')
            ->select('tarefas.*', 'users.name as criador_nome')
            ->where('tarefas.id_item', $id)
            ->get();

        return $tarefas;
    }

    public function AdicionaTarefaItem($data){
        
        $periodo = TarefaPeriodo::find($data->id_periodo);

        $newExecution = date('Y-m-d', strtotime($periodo['periodo'], strtotime($data->data_de_inicio)));

        $tarefa = Tarefa::create([
            'id_item' => $data->id_item,
            'nome_da_tarefa' => $data->nome_da_tarefa,
            'descricao' => $data->descricao,
            'data_de_inicio' => $data->data_de_inicio,
            'data_proxima_execucao' => $newExecution,
            'nome_da_tarefa' => $data->nome_da_tarefa,
            'id_periodo' => $data->id_periodo,
            'id_criador' => Auth::user()->id,
        ]);

        return $tarefa;
    }

    public function AdicionarTarefa($data){

        $periodo = TarefaPeriodo::find($data->id_periodo);

        $newExecution = date('Y-m-d', strtotime($periodo['periodo'], strtotime($data->data_de_inicio)));

        $tarefa = Tarefa::create([
            'nome_da_tarefa' => $data->nome_da_tarefa,
            'descricao' => $data->descricao,
            'data_de_inicio' => $data->data_de_inicio,
            'data_proxima_execucao' => $newExecution,
            'nome_da_tarefa' => $data->nome_da_tarefa,
            'id_periodo' => $data->id_periodo,
            'id_criador' => Auth::user()->id,
        ]);

        return $tarefa;
    }
}
