@extends('dashboard-base')

@section('content')
    <main id="dashboard">

        @component('menu-categorias', ['categorias' => $categorias])
            
        @endcomponent

        <section class="dashboard-exibicao">
            <div class="items-atributos">
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

                <form action="" method="post">

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
                            Patrimônio:  <input type="text" value="{{ $item->prefixo.sprintf("%04s",$item->patrimonio) }}" readonly>
                        </span>
                        <span>
                            Localização: <input type="text" value="{{ $item->localizacao }}" readonly>
                        </span>
                        <span>
                            Data de Aquisição:  <input type="text" value="{{ $item->data_de_aquisicao }}" readonly>
                        </span>
                        <span>
                            Categoria:  <input type="text" value="{{ $item->categoria_nome }}" readonly>
                        </span>
                        <span>
                            Adicionado em:  <input type="text" value="{{ $item->created_at }}" readonly>
                        </span>
                        <span>
                            Adicionado por:  <input type="text" value="{{ $item->criador_nome }}" readonly>
                        </span>

                        <span>
                            Atualizado em:  <input type="text" value="{{ $item->updated_at }}" readonly>
                        </span>
                        @php
                            // dd($items);
                        @endphp
                        <span>
                            Atualizado por:  <input type="text" value="{{ isset($items[2]->name) ? $items[2]->name : 'N/A' }}" readonly>
                        </span>
                        
                    @endforeach

                    <hr>

                    @foreach ($items[1] as $item)
                        <span>
                            {{ $item->nome_do_atributo .": " }}<input type="text" value="{{ isset($item->valor) ? $item->valor : 'N/A' }}" readonly>
                        </span>
                    @endforeach

                </form>

                
            </div>
            <div class="historico">

                <h2>Historico:</h2>
                @php
                // dd($items);

                foreach ($items[3] as $item) {
                    echo"
                    <div class='historico-item'>
                        <h3>$item->usuario_nome</h3>
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

            <a class="alert" href='{{route("dashboardEdita", $items[0][0]->id)}}' target="__blank">Editar</a>

        </div>
    </main>
@endsection