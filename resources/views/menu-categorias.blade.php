<aside>
    <div>Categorias:</div>

    @if ($categorias)
        @foreach ($categorias as $categoria)
            <a href="{{ route('dashboardHome', ['id' => $categoria->id]) }}">{{$categoria->nome}}</a>
        @endforeach      
    @else
        <a href="#">Nenhuma Categoria Encontrada</a>
    @endif
          
    
</aside>