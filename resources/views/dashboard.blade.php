@extends('dashboard-base')

@section('content')
    <main id="dashboard">
        @component('menu-categorias', ['categorias' => $categorias])
            
        @endcomponent
        <section>
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
                                @if ($i == null)
                                    @php
                                        $item->$key = "N/A";
                                    @endphp
                                @endif
                            @endforeach

                            <td>{{ $item->prefixo.sprintf("%04s",$item->patrimonio) }}</td>
                            <td>{{ $item->nome }}</td>
                            <td>{{ $item->localizacao }}</td>
                            <td>{{ $item->data_de_aquisicao }}</td>
                            <td>{{ $item->categoria_nome }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->criador_nome }}</td>
                            <td><a class="action" href='{{route("dashboardVer", $item->id)}}' target="__blank">Ver</a></td>
                            <td><a class="alert" href='{{route("dashboardEdita", $item->id)}}' target="__blank">Editar</a></td>
                            <td><a class="alert" href='{{--{{route("", $id)}}--}}' target="__blank">Excluir</a></td>
                        </tr>
                        
                    @endforeach
                    


                </table>
            @endif
           
        </section>
    </main>
@endsection