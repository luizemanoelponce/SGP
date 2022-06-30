@extends('dashboard-base')

@section('content')
    <main id="dashboard">

        @component('menu-categorias', ['categorias' => $categorias])
            
        @endcomponent

        <section class="dashboard-edicao" style="">
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

            

            <h2>Justificativa de Desabilitação:</h2>

            <form action="{{ route('dashboardExcluir', ['id' => $id_item]) }}" method="post">

                @csrf

                    <input type="hidden" name="id_item" value="{{$id_item}}" required>    

                    <span>
                        <textarea name="descricao" required></textarea>
                    </span>

                <hr>

                <input type="submit" value="Desabilitar" style="color:red;">

            </form>

            <div class="botoesAcao">

                <a class="voltar" href="{{route('dashboardHome')}}">Voltar</a>

            </div>
            
            
        </section>
    </main>
@endsection