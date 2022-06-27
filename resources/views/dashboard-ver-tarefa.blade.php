@extends('dashboard-base')

@section('content')
    <main id="dashboard">

        @component('menu-categorias', ['categorias' => $categorias])
            
        @endcomponent

        <section class="dashboard-exibicao" style="flex-direction: column;">

            <h2>{{$tarefas[0]->nome_da_tarefa}}</h2>
            <strong>Descrição: </strong>
           @php

                if($tarefas[0]->data_proxima_execucao){
                    $tarefas[0]->data_proxima_execucao = new DateTime($tarefas[0]->data_proxima_execucao);
                    $tarefas[0]->data_proxima_execucao = $tarefas[0]->data_proxima_execucao->format('d/m/Y');
                }
                if($tarefas[0]->data_de_inicio){
                    $tarefas[0]->data_de_inicio = new DateTime($tarefas[0]->data_de_inicio);
                    $tarefas[0]->data_de_inicio = $tarefas[0]->data_de_inicio->format('d/m/Y');
                }

               echo "
                    <div>
                        ". $tarefas[0]->descricao . "
                    </div>
                ";
           @endphp
            <span>
                <strong> Data da Tarefa:  </strong> {{ $tarefas[0]->data_proxima_execucao }} <br>
                <strong> Início da Tarefa:  </strong>  {{ $tarefas[0]->data_de_inicio }}<br>
                <strong> Criador da Tarefa:  </strong> {{ $tarefas[0]->criador_nome }}<br>
            </span>
        
        </section>

        <div class="botoesAcao">

            <a class="voltar" href="{{ route('dashboardHome') }}">
                Voltar
            </a>

            <a class="alert" href='{{route("dashboardTarefaConcluir", $tarefas[0]->id)}}' target="__blank">Concluir</a>

        </div>
    </main>
@endsection