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

            

            <h2>Adicionar Categoria:</h2>

            <form action="{{ route('dashboardAdicionarCategoria') }}" method="post">

                @csrf
                    
                    <span>
                        Nome:  <input name="nome" type="text" value="" required>
                    </span>

                    <span>
                        Prefixo: <input name="prefixo" type="text" value="" required>
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