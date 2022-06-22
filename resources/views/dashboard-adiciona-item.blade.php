@extends('dashboard-base')

@section('content')
    <main id="dashboard">

        @component('menu-categorias', ['categorias' => $categorias])
            
        @endcomponent

        <section class="dashboard-edicao">
            @php

                if(isset($_GET['status'])){
                    echo '<div class="status">'. $_GET['status'] .'</div>';
                }

            @endphp

            

            <h2>Adicionar Item</h2>

            <form action="{{ route('dashboardAdicionar') }}" method="post">

                @csrf
                    
                    <span>
                        Nome:  <input name="nome" type="text" value="" required>
                    </span>

                    <span>
                        Localização: <input name="localizacao" type="text" value="" required>
                    </span>
                    <span>
                        Data de Aquisição:  <input name="data_de_aquisicao" type="date" value="" required>
                    </span>
                    <span>
                         Categoria:  <select name="id_categoria" required>
                             @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                             @endforeach
                          </select>
                    </span>

                <hr>

                <input type="submit" value="Salvar ">

            </form>

            <div class="botoesAcao">

                <a class="voltar" href="{{route('dashboardHome')}}">Voltar</a>

            </div>
            
        </section>
    </main>
@endsection