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

                if(isset($atributo)){
                    foreach($categorias as $categoria) {
                        if($categoria->id == $atributo->id_categoria){
                            echo '<div class="status"> Atributo ' . $atributo->nome_do_atributo . ' Adiconado na Categoria ' . $categoria->nome  . '</div>';
                        }
                    }
                }

            @endphp

            

            <h2>Adicionar Histórico:</h2>

            <form action="{{ route('AdicionarHistorico') }}" method="post">

                @csrf

                    <input type="hidden" name="id_item" value="{{$id}}">    

                    <span>
                        <textarea name="descricao">

                        </textarea>
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