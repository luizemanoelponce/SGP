@extends('dashboard-base')

@section('content')
    <main id="dashboard">

        @component('menu-categorias', ['categorias' => $categorias])
            
        @endcomponent

        <section class="dashboard-edicao" style="">

            <br>

            @php

                if(isset($_GET['status'])){
                    echo '<div class="status">'. $_GET['status'] .'</div>';
                }

            @endphp

            

            <h2>Adicionar Tarefa:</h2>

            <form action="{{ route('dashboardAdicionarTarefa') }}" method="post">

                @csrf

                    <input type="hidden" name="id_item" value="{{$id_item}}">

                    <span>Nome da Tarefa:
                        <input type="text" name="nome_da_tarefa" required>
                    </span>

                    <span>  Data de início
                        <input type="date" name="data_de_inicio" required>
                    </span>

                    <span>
                        Período de Execução:  <select name="id_periodo" required>
                            @foreach ($periodos as $periodo)
                               <option value="{{ $periodo->id }}">{{ $periodo->periodo }}</option>
                            @endforeach
                         </select>
                   </span>

                    <span>Descrição: <br>
                        <textarea name="descricao" required></textarea>
                    </span>

                <hr>

                <input type="submit" value="Salvar ">

            </form>

            <div class="botoesAcao">

                @if ($id_item)
                    <a class="voltar" href="{{route('dashboardEdita', ['id' => $id_item])}}">Voltar</a>
                @else
                    <a class="voltar" href="{{route('dashboardHome')}}">Voltar</a>
                @endif
            </div>
            
            
        </section>
    </main>
@endsection