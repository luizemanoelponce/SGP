@extends('dashboard-base')

@section('content')
    <main id="dashboard">

        @component('menu-categorias', ['categorias' => $categorias])
            
        @endcomponent

        <section class="dashboard-edicao row">
            <div class="items-atributos">
                @php
                $indices_atributos = "";

                    $items = json_decode($items);
                    
                    if($items[0][0]->created_at){
                        $items[0][0]->created_at = new DateTime($items[0][0]->created_at);
                        $items[0][0]->created_at = $items[0][0]->created_at->format('d/m/Y');
                    }
                    if($items[0][0]->updated_at){
                        $items[0][0]->updated_at = new DateTime($items[0][0]->updated_at);
                        $items[0][0]->updated_at = $items[0][0]->updated_at->format('d/m/Y');
                    }

                    if(isset($_GET['status'])){
                        echo '<div class="status">'. $_GET['status'] .'</div>';
                    }

                @endphp

                

                <h2>{{ $items[0][0]->nome }}</h2>

                <form action="{{ route('dashboardEditar', $items[0][0]->id) }}" method="post">

                    @csrf

                    @foreach ($items[0] as $item)
                        @foreach ($item as $key => $i)
                            @if ($i == null)
                                @php
                                    $item->$key = "N/A";
                                @endphp
                            @endif
                        @endforeach

                        @php
                            if(!$items[2]){
                                $items[2] = 'N/A';
                            }
                        @endphp

                        <input type="hidden" name="id_item" value="{{ $item->id }}">
                        
                        <span>
                            Nome:  <input name="nome" type="text" value="{{ $item->nome }}" required>
                        </span>

                        <span>
                            Patrim??nio:  <input type="text" value="{{ $item->prefixo.sprintf("%04s",$item->patrimonio) }}" readonly required>
                        </span>
                        <span>
                            Localiza????o: <input name="localizacao" type="text" value="{{ $item->localizacao }}" required>
                        </span>
                        <span>
                            Data de Aquisi????o:  <input name="data_de_aquisicao" type="date" value="{{ $item->data_de_aquisicao == 'N/A' ? '0001-01-01' :  $item->data_de_aquisicao  }}">
                        </span>
                        <span>
                            Categoria:  <select name="id_categoria">
                                @foreach ($categorias as $categoria)
                                    @if ($categoria->id == $item->id_categoria)
                                        <option value="{{ $categoria->id }}" selected>{{ $categoria->nome }}</option>
                                    @else
                                        <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </span>
                        <span>
                            Adicionado em:  <input name="" type="text" value="{{ $item->created_at }}" readonly>
                        </span>
                        <span>
                            Adicionado por:  <input name="" type="text" value="{{ $item->criador_nome }}" readonly>
                        </span>

                        <span>
                            Atualizado em:  <input name="" type="text" value="{{ $item->updated_at }}" readonly>
                        </span>
                        <span>
                            Atualizado por:  <input name="" type="text" value="{{ isset($items[2]->name) ? $items[2]->name : 'N/A' }}" readonly>
                        </span>
                        
                    @endforeach

                    <hr>

                    @foreach ($items[1] as $item)
                        <span>
                            {{ $item->nome_do_atributo .": " }}<input name=" {{ isset($item->id_nome_atributo) ? $item->id_nome_atributo . '|' . $item->id_item : $item->id . "|" . $items[0][0]->id . '|' . $item->id_categoria  }}" 
                                type="text" value="{{ isset($item->valor) ? $item->valor : 'N/A' }}" >

                            @php    
                                $indices_atributos .= isset($item->id_nome_atributo) ? $item->id_nome_atributo . '|' . $item->id_item : $item->id . "|" . $items[0][0]->id . '|' . $item->id_categoria;
                                $indices_atributos .= "-";
                            @endphp
                        </span>
                    @endforeach
                    

                    <input type="hidden" name="indices_atributos" value="{{ $indices_atributos }}" >

                    <input type="submit" value="Salvar ">

                </form>
                <div class="tarefas">
                    <br>
                    <a href="{{ route('dashboardAdicionaTarefa', ['id' => $items[0][0]->id]) }}" target="_blank">Adicionar</a>
                    <br>
                    <strong>Tarefas:</strong>
                    @if (!isset($tarefas[0]))
                        <h2>Nenhuma Tarefa Cadastrada</h2>
                    @else
                        <br>
                        <table>
                            <tr class="table-row-light">
                                <th>Tarefa</th>
                                <th>Iniciada em:</th>
                                <th>Iniciada por:</th>
                                <th colspan="2">A????es:</th>
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
                                    <td>{{ $tarefa->data_de_inicio }}</td>
                                    <td>{{ $tarefa->criador_nome }} </td>
                                    <td><a class="action" href='{{route("dashboardTarefaVer", $tarefa->id)}}' target="__blank">Ver</a></td>
                                    <td><a class="alert" href='{{route("dashboardTarefaConcluir", $tarefa->id)}}' target="__blank">Concluir</a></td>
                                </tr>

                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
            <div class="historico">
                
                <h2>Historico:</h2>

                <a href="{{ route('AdicionaHistorico', ['id' => $items[0][0]->id]) }}" target="_blank">Adicionar</a>
                @php

                    foreach ($items[3] as $item) {

                        $item->created_at = new DateTime($item->created_at);
                        $item->created_at = $item->created_at->format('d/m/Y H:m:s');

                        echo"
                        <div class='historico-item'>
                            <strong>$item->usuario_nome</strong>
                            <article>$item->descricao</article>
                            <small>$item->created_at</small>
                        </div> <hr>
                        ";
                    }
                    
                @endphp
            </div>
        </section>


        <div class="botoesAcao">
            @php
                if(!$items[0][0]->id_categoria){
                    echo '<a class="voltar" href="' . route('dashboardHome') . '">
                        Voltar
                    </a>';
                } else {
                    echo '<a class="voltar" href="' . route('dashboardHome', ['id' => $items[0][0]->id_categoria] ) . '">
                        Voltar
                    </a>';
                }
            @endphp
        </div>
    </main>
@endsection