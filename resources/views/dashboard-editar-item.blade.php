@extends('dashboard-base')

@section('content')
    <main id="dashboard">

        @component('menu-categorias', ['categorias' => $categorias])
            
        @endcomponent

        <section class="dashboard-edicao">
            @php

                $items = json_decode($items);
                
                if($items[0][0]->created_at){
                    $items[0][0]->created_at = new DateTime($items[0][0]->created_at);
                    $items[0][0]->created_at = $items[0][0]->created_at->format('d/m/Y');
                }
                if($items[0][0]->updated_at){
                    $items[0][0]->updated_at = new DateTime($items[0][0]->updated_at);
                    $items[0][0]->updated_at = $items[0][0]->updated_at->format('d/m/Y');
                }
                if($items[0][0]->data_de_aquisicao){
                    $items[0][0]->data_de_aquisicao = new DateTime($items[0][0]->data_de_aquisicao);
                    $items[0][0]->data_de_aquisicao = $items[0][0]->data_de_aquisicao->format('d/m/Y');
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
                    
                    <span>
                        Nome:  <input name="nome" type="text" value="{{ $item->nome }}">
                    </span>

                    <span>
                        Patrimônio:  <input type="text" value="{{ $item->prefixo.sprintf("%04s",$item->patrimonio) }}" readonly>
                    </span>
                    <span>
                        Localização: <input name="localizacao" type="text" value="{{ $item->localizacao }}">
                    </span>
                    <span>
                        Data de Aquisição:  <input name="data_de_aquisicao" type="text" value="{{ $item->data_de_aquisicao }}">
                    </span>
                    <span>
                         Categoria:  <select name="categoria">
                            <option value="valor1">Valor 1</option>
                            <option value="valor2" selected>Valor 2</option>
                            <option value="valor3">Valor 3</option>
                          </select>
                    </span>
                    <span>
                        Adicionado em:  <input name="" type="text" value="{{ $item->created_at }}" readonly>
                    </span>
                    <span>
                        Adicionado por:  <input name="" type="text" value="{{ $item->criador_nome }}" readonly>
                    </span>

                    <span>
                        Atualizado em:  <input name="" type="text" value="{{ $item->created_at }}" readonly>
                    </span>
                    <span>
                        Atualizado por:  <input name="" type="text" value="{{ $items[2] }}" readonly>
                    </span>
                    
                @endforeach

                <hr>

                @foreach ($items[1] as $item)
                    <span>
                        @php    
                            // dd($item);   
                        @endphp
                        {{ $item->nome_do_atributo .": " }}<input name=" {{ isset($item->id_nome_atributo) ? $item->id_nome_atributo . '|' . $item->id_item : $item->id . "|" . $items[0][0]->id . '|' . $item->id_categoria  }}" 
                            type="text" value="{{ isset($item->valor) ? $item->valor : 'N/A' }}" >
                    </span>
                @endforeach

                <input type="submit" value="Salvar ">

            </form>

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

            
            

           
        </section>
    </main>
@endsection