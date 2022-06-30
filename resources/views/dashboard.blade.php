@extends('dashboard-base')

@section('content')
    <main id="dashboard">
        @component('menu-categorias', ['categorias' => $categorias])
            
        @endcomponent
        <section class="dashboardbase">
            @if ($items !== '')
                <table id="tabela">
                    <tr class="table-row">
                        <th></th>
                        <th>Item:</th>
                        <th>Localização:</th>
                        <th>Aquisição:</th>
                        <th>Categoria:</th>
                        <th>Data de Cadastro:</th>
                        <th>Cadastrado por:</th>
                    </tr>

                    @php $class_calc=0; @endphp

                    @foreach (json_decode($items) as $item)
                            @php

                                if($item->created_at){
                                    $item->created_at = new DateTime($item->created_at);
                                    $item->created_at = $item->created_at->format('d/m/Y');
                                }
                                if($item->data_de_aquisicao){
                                    $item->data_de_aquisicao = new DateTime($item->data_de_aquisicao);
                                    $item->data_de_aquisicao = $item->data_de_aquisicao->format('d/m/Y');
                                }
                                
                                $class_calc = 1;

                                // $class_calc = $class_calc + 1;

                                if ($class_calc > 2) {
                                    $class_calc = 1;
                                }

                                if ($class_calc == 1){
                                    $class = "table-row-light";
                                } else {
                                    $class = "table-row-black";
                                }

                                echo'<tr class="table-row ' . $class . '">';

                            @endphp

                            @foreach ($item as $key => $i)
                                @if ($i == null || $i === '01/01/0001')
                                    @php
                                        $item->$key = "N/I";
                                    @endphp
                                @endif
                            @endforeach

                            <td>{{ $item->prefixo.sprintf("%02s",$item->patrimonio) }}</td>
                            <td>{{ $item->nome }}</td>
                            <td>{{ $item->localizacao }}</td>
                            <td>{{ $item->data_de_aquisicao }}</td>
                            <td>{{ $item->categoria_nome }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->criador_nome }}</td>
                            <td><a class="action" href='{{route("dashboardVer", $item->id)}}' target="__blank">Ver</a></td>
                            <td><a class="alert" href='{{route("dashboardEdita", $item->id)}}' target="__blank">Editar</a></td>
                            <td><a class="alert" href='{{route("dashboardExclui", $item->id)}}' target="__blank">Excluir</a></td>
                        </tr>
                        
                    @endforeach
                    


                </table>
            @endif

            @if($tarefas !== '')
                <br>
                <a href="{{ route('dashboardAdicionaTarefa') }}" target="_blank">Adicionar</a>
                @if (!isset($tarefas[0]))
                    <h2>Nenhuma Tarefa Pendente</h2>
                @else
                    <br>
                    <table>
                        <tr class="table-row-light">
                            <th>Tarefa</th>
                            <th>Dia da tarefa</th>
                            <th>Iniciada em:</th>
                            <th>Iniciada por:</th>
                            <th colspan="2">Ações:</th>
                        </tr>
                        
                        @foreach($tarefas as $tarefa)

                            @php 

                                if($tarefa->data_proxima_execucao){
                                    $tarefa->data_proxima_execucao = new DateTime($tarefa->data_proxima_execucao);
                                    $tarefa->data_proxima_execucao = $tarefa->data_proxima_execucao->format('d/m/Y');
                                }
                                if($tarefa->data_de_inicio){
                                    $tarefa->data_de_inicio = new DateTime($tarefa->data_de_inicio);
                                    $tarefa->data_de_inicio = $tarefa->data_de_inicio->format('d/m/Y');
                                }

                            @endphp

                            <tr class="table-row-light">
                                <td>{{ $tarefa->nome_da_tarefa }}</td>
                                <td>{{ $tarefa->data_proxima_execucao }}</td>
                                <td>{{ $tarefa->data_de_inicio }}</td>
                                <td>{{ $tarefa->criador_nome }} </td>
                                <td><a class="action" href='{{route("dashboardTarefaVer", $tarefa->id)}}' target="__blank">Ver</a></td>
                                <td><a class="alert" href='{{route("dashboardTarefaConcluir", $tarefa->id)}}' target="__blank">Concluir</a></td>
                            </tr>

                        @endforeach
                    </table>
                @endif
            @endif
           
        </section>
    </main>
@endsection